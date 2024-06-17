<?php
class Checkouts extends Model
{
    protected $table = 'category';

    public function createOrder($orderData, $cartItems)
    {
        $pdo = $this->connect();

        // Start a transaction
        $pdo->beginTransaction();

        try {
            // Insert into payment
            $stmt = $pdo->prepare("INSERT INTO payment (payment_method, cus_id) VALUES (:payment_method, :cus_id)");
            $stmt->execute([
                ':payment_method' => $orderData['payment_method'],
                ':cus_id' => $orderData['cus_id']
            ]);
            $paymentId = $pdo->lastInsertId();
            echo "Inserted Payment ID: " . $paymentId . "\n"; // Debug

            // Insert into orders
            $stmt = $pdo->prepare("
                INSERT INTO orders (order_subtotal, order_total, orderstat_id, payment_id, cus_id, deliverm_id, pstat_id) 
                VALUES (:order_subtotal, :order_total, 1, :payment_id, :cus_id, 1, :pstat_id)
            ");
            $stmt->execute([
                ':order_subtotal' => $orderData['order_subtotal'],
                ':order_total' => $orderData['order_total'],
                ':payment_id' => $paymentId,
                ':cus_id' => $orderData['cus_id'],
                ':pstat_id' => $orderData['pstat_id']
            ]);

            // Query the latest order ID
            $stmt = $pdo->query("SELECT MAX(order_id) AS order_id FROM orders WHERE cus_id = " . $orderData['cus_id'] . " AND payment_id = " . $paymentId);
            $result = $stmt->fetch();
            $orderId = $result['order_id'];
            echo "Queried Order ID: " . $orderId . "\n"; // Debug

            if (!$orderId) {
                // Handle error, possibly rollback
                $pdo->rollBack();
                return ['success' => false, 'error' => 'Order creation failed'];
            }

            // Update stock and insert order items
            foreach ($cartItems as $item) {
                // Fetch current stock
                $stmt = $pdo->prepare("SELECT prod_stock FROM products WHERE prod_id = :prod_id");
                $stmt->execute([':prod_id' => $item['prod_id']]);
                $product = $stmt->fetch();

                if ($product['prod_stock'] < $item['qty']) {
                    // Insufficient stock, rollback transaction
                    $pdo->rollBack();
                    return ['success' => false, 'error' => 'Insufficient stock for product ID ' . $item['prod_id']];
                }

                // Decrease stock
                $newStock = $product['prod_stock'] - $item['qty'];
                $stmt = $pdo->prepare("UPDATE products SET prod_stock = :newStock WHERE prod_id = :prod_id");
                $stmt->execute([':newStock' => $newStock, ':prod_id' => $item['prod_id']]);

                // Insert into order_item
                $stmt = $pdo->prepare("
                    INSERT INTO order_item (orderi_qty, order_id, prod_id) 
                    VALUES (:orderi_qty, :order_id, :prod_id)
                ");
                $stmt->execute([
                    ':orderi_qty' => $item['qty'],
                    ':order_id' => $orderId,
                    ':prod_id' => $item['prod_id']
                ]);
            }

            // Commit the transaction
            $pdo->commit();

            return ['success' => true, 'order_id' => $orderId];

        } catch (Exception $e) {
            // Rollback the transaction in case of error
            $pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
?>
