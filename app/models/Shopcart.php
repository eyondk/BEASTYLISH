<?php

class Shopcart
{
    use Model;

    protected $table = 'cart';

    protected $allowedColumns = [
        'cart_qty',
        'cart_status',
        'cus_id',
        'prod_id'
    ];

    // // Fetch all items in the cart for a specific customer
    // public function get_cart_items($cus_id)
    // {
    //     try {
    //         $conn = $this->connect();
    //         $stmt = $conn->prepare("
    //             SELECT c.*, p.prod_name, p.prod_price, pi.image_path
    //             FROM cart c
    //             LEFT JOIN products p ON c.prod_id = p.prod_id
    //             LEFT JOIN product_images pi ON p.prod_id = pi.prod_id
    //             WHERE c.cus_id = :cus_id AND c.cart_status = 'active'
    //         ");
    //         $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         error_log("Database error: " . $e->getMessage());
    //         return [];
    //     }
    // }

    //  // Add item to cart
    // public function add_to_cart($cartData)
    // {
    //     try {
    //         $conn = $this->connect();

    //         // Check if product already exists in cart for this customer
    //         $stmt = $conn->prepare("
    //             SELECT * FROM cart 
    //             WHERE cus_id = :cus_id AND prod_id = :prod_id AND cart_status = 'active'
    //         ");
    //         $stmt->execute([
    //             ':cus_id' => $cartData['cus_id'],
    //             ':prod_id' => $cartData['prod_id']
    //         ]);

    //         $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    //         if ($existingItem) {
    //             // If product exists, update the quantity
    //             $newQty = $existingItem['cart_qty'] + $cartData['cart_qty'];
    //             $stmt = $conn->prepare("
    //                 UPDATE cart 
    //                 SET cart_qty = :cart_qty 
    //                 WHERE cart_id = :cart_id
    //             ");
    //             $stmt->execute([
    //                 ':cart_qty' => $newQty,
    //                 ':cart_id' => $existingItem['cart_id']
    //             ]);
    //         } else {
    //             // If product does not exist, add new entry
    //             $stmt = $conn->prepare("
    //                 INSERT INTO cart (cart_qty, cart_status, cus_id, prod_id) 
    //                 VALUES (:cart_qty, :cart_status, :cus_id, :prod_id)
    //             ");
    //             $stmt->execute([
    //                 ':cart_qty' => $cartData['cart_qty'],
    //                 ':cart_status' => $cartData['cart_status'],
    //                 ':cus_id' => $cartData['cus_id'],
    //                 ':prod_id' => $cartData['prod_id']
    //             ]);
    //         }

    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Database error: " . $e->getMessage());
    //         return false;
    //     }
    // }


    // // Update cart item quantity
    // public function update_cart_item($cart_id, $cart_qty)
    // {
    //     try {
    //         $conn = $this->connect();
    //         $stmt = $conn->prepare("
    //             UPDATE cart 
    //             SET cart_qty = :cart_qty
    //             WHERE cart_id = :cart_id
    //         ");
    //         $stmt->bindParam(':cart_qty', $cart_qty, PDO::PARAM_INT);
    //         $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Database error: " . $e->getMessage());
    //         return false;
    //     }
    // }

    // // Remove item from cart
    // public function remove_from_cart($cart_id)
    // {
    //     try {
    //         $conn = $this->connect();
    //         $stmt = $conn->prepare("
    //             DELETE FROM cart WHERE cart_id = :cart_id
    //         ");
    //         $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Database error: " . $e->getMessage());
    //         return false;
    //     }
    // }

    public function get_cart_items($cus_id)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                SELECT c.*, p.prod_name, p.prod_price, pi.image_path, p.prod_stock
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

            // Fetch product stock
            $stmt = $conn->prepare("
                SELECT prod_stock 
                FROM products 
                WHERE prod_id = :prod_id
            ");
            $stmt->execute([
                ':prod_id' => $cartData['prod_id']
            ]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$product || $cartData['cart_qty'] > $product['prod_stock']) {
                return false; // Quantity exceeds available stock
            }

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
                if ($newQty > $product['prod_stock']) {
                    return false; // Quantity exceeds available stock
                }
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

            // Fetch product stock
            $stmt = $conn->prepare("
                SELECT p.prod_stock 
                FROM cart c
                LEFT JOIN products p ON c.prod_id = p.prod_id
                WHERE c.cart_id = :cart_id
            ");
            $stmt->execute([
                ':cart_id' => $cart_id
            ]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$product || $cart_qty > $product['prod_stock']) {
                return false; // Quantity exceeds available stock
            }

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

    //   public function get_cart_quantity($cus_id, $product_id)
    // {
    //     $sql = "SELECT cart_qty FROM cart WHERE cus_id = :cus_id AND prod_id = :prod_id AND cart_status = 'active'";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute(['cus_id' => $cus_id, 'prod_id' => $product_id]);
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $result ? $result['cart_qty'] : 0;
    // }

    //  public function get_cart_quantity($cus_id, $prod_id)
    // {
    //     try {
    //         $conn = $this->connect();
    //         $stmt = $conn->prepare("
    //             SELECT SUM(cart_qty) AS cart_qty 
    //             FROM cart 
    //             WHERE cus_id = :cus_id 
    //             AND prod_id = :prod_id 
    //             AND cart_status = 'active'
    //         ");
    //         $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
    //         $stmt->bindParam(':prod_id', $prod_id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $result ? $result['cart_qty'] : 0;
    //     } catch (PDOException $e) {
    //         error_log("Database error: " . $e->getMessage());
    //         return 0;
    //     }
    // }

    public function get_cart_quantity($cus_id, $prod_id)
{
    try {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT SUM(cart_qty) as quantity FROM cart WHERE cus_id = :cus_id AND prod_id = :prod_id AND cart_status = 'active'");
        $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
        $stmt->bindParam(':prod_id', $prod_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['quantity'] ?? 0;
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        return 0;
    }
}


 // Remove all items from cart for a specific customer
    public function remove_all_from_cart($cus_id)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                DELETE FROM cart WHERE cus_id = :cus_id
            ");
            $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }


}
?>
