<?php

class Shopcart extends Model
{
    

    protected $table = 'cart';

    protected $allowedColumns = [
        'cart_qty',
        'cart_status',
        'cus_id',
        'prod_id'
    ];

    // Fetch all items in the cart for a specific customer
    public function get_cart_items($cus_id)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                SELECT c.*, p.prod_name, p.prod_price, pi.image_path
                FROM cart c
                LEFT JOIN products p ON c.prod_id = p.prod_id
                LEFT JOIN product_images pi ON p.prod_id = pi.prod_id
                WHERE c.cus_id = :cus_id AND c.cart_status = 'active'
            ");
            $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

     // Add item to cart
    public function add_to_cart($cartData)
    {
        try {
            $conn = $this->connect();

            // Check if product already exists in cart for this customer
            $stmt = $conn->prepare("
                SELECT * FROM cart 
                WHERE cus_id = :cus_id AND prod_id = :prod_id AND cart_status = 'active'
            ");
            $stmt->execute([
                ':cus_id' => $cartData['cus_id'],
                ':prod_id' => $cartData['prod_id']
            ]);

            $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingItem) {
                // If product exists, update the quantity
                $newQty = $existingItem['cart_qty'] + $cartData['cart_qty'];
                $stmt = $conn->prepare("
                    UPDATE cart 
                    SET cart_qty = :cart_qty 
                    WHERE cart_id = :cart_id
                ");
                $stmt->execute([
                    ':cart_qty' => $newQty,
                    ':cart_id' => $existingItem['cart_id']
                ]);
            } else {
                // If product does not exist, add new entry
                $stmt = $conn->prepare("
                    INSERT INTO cart (cart_qty, cart_status, cus_id, prod_id) 
                    VALUES (:cart_qty, :cart_status, :cus_id, :prod_id)
                ");
                $stmt->execute([
                    ':cart_qty' => $cartData['cart_qty'],
                    ':cart_status' => $cartData['cart_status'],
                    ':cus_id' => $cartData['cus_id'],
                    ':prod_id' => $cartData['prod_id']
                ]);
            }

            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }


    // Update cart item quantity
    public function update_cart_item($cart_id, $cart_qty)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                UPDATE cart 
                SET cart_qty = :cart_qty
                WHERE cart_id = :cart_id
            ");
            $stmt->bindParam(':cart_qty', $cart_qty, PDO::PARAM_INT);
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    // Remove item from cart
    public function remove_from_cart($cart_id)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                DELETE FROM cart WHERE cart_id = :cart_id
            ");
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    // Fetch items in the cart by their IDs
    public function get_cart_items_by_ids($cart_ids)
    {
        try {
            $conn = $this->connect();
            $placeholders = implode(',', array_fill(0, count($cart_ids), '?'));
            $stmt = $conn->prepare("
                SELECT c.*, p.prod_name, p.prod_price, pi.image_path
                FROM cart c
                LEFT JOIN products p ON c.prod_id = p.prod_id
                LEFT JOIN product_images pi ON p.prod_id = pi.prod_id
                WHERE c.cart_id IN ($placeholders) AND c.cart_status = 'active'
            ");
            $stmt->execute($cart_ids);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
?>