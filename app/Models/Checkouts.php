<?php 

class Checkouts extends Model
{
    protected $table = 'category';

    public function createOrder($orderData, $cartItems) {
        // Check for required fields
        // if (empty($orderData['order_subtotal']) || empty($orderData['order_total']) || 
        //     empty($orderData['payment_method']) || empty($orderData['cus_id']) || 
        //     empty($cartItems)) {
        //     return ['success' => false, 'error' => 'Missing required fields'];
        // }
    
        $pdo = $this->connect();
    
        // Start a transaction
        $pdo->beginTransaction();
    
        try {
           
    
    
                $stmt = $pdo->prepare("INSERT INTO payment (payment_method, cus_id) VALUES (:payment_method, :cus_id)");
                $stmt->execute([':payment_method' => $orderData['payment_method'],
                                ':cus_id' => $orderData['cus_id']]);
                $paymentId = $pdo->lastInsertId();
            
    
        // Insert into orders
        $stmt = $pdo->prepare("
        INSERT INTO orders (order_subtotal, order_total, orderstat_id, payment_id, cus_id, deliverm_id, pstat_id) 
        VALUES (:order_subtotal, :order_total, 1, :payment_id, :cus_id, 1, 1)
            ");
        $stmt->execute([
            ':order_subtotal' => $orderData['order_subtotal'],
            ':order_total' => $orderData['order_total'],
            ':payment_id' => $paymentId,
            ':cus_id' => $orderData['cus_id']
        ]);

       // Get the last inserted order ID
       $orderId = $pdo->lastInsertId();
       echo "Inserted Order ID: " . $orderId . "\n"; // Debug

        if (!$orderId) {
            // Handle error, possibly rollback
            $pdo->rollBack();
            return ['success' => false, 'error' => 'Order creation failed'];
        }

       
       

        
        $stmt = $pdo->prepare("
            INSERT INTO order_item (orderi_qty, order_id, prod_id) 
            VALUES (:orderi_qty, :order_id, :prod_id)
        ");
        foreach ($cartItems as $item) {
            $stmt->execute([
                ':orderi_qty' => $item['qty'],
                ':order_id' => $orderId,
                ':prod_id' => $item['prod_id']  
            ]);
        }

        $pdo->commit();  // Commit the transaction for order items

        return ['success' => true, 'order_id' => $orderId];

        } catch (Exception $e) {
        $pdo->rollBack();
        return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    

}