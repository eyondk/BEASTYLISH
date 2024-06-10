    <?php
    class Model extends Database {
        public function __construct() {
            $this->conn = $this->connect();
        }

        public function insertProduct($data, $files) {
            try {
                // Validate and upload product images
                $productImages = [];
                $uploadSuccess = true;
                $productImageFolder = '../public/assets/uploads/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $maxFileSize = 5000000; // 5MB limit

                foreach ($files['product_image']['name'] as $key => $imageName) {
                    $imageTmpName = $files['product_image']['tmp_name'][$key];
                    $imageSize = $files['product_image']['size'][$key];
                    $imageType = mime_content_type($imageTmpName); // Use mime_content_type for better compatibility

                    if (!in_array($imageType, $allowedTypes)) {
                        return ['success' => false, 'messages' => ["Invalid file format for $imageName."]];
                    }

                    if ($imageSize > $maxFileSize) {
                        return ['success' => false, 'messages' => ["File size for $imageName exceeds the limit of 5MB."]];
                    }

                    $targetPath = $productImageFolder . basename($imageName);

                    if (!move_uploaded_file($imageTmpName, $targetPath)) {
                        return ['success' => false, 'messages' => ["Failed to upload $imageName."]];
                    }

                    $productImages[] = $imageName; // Store image names for database insertion
                }

                // Insert product details into the products table using named placeholders
                $stmt = $this->conn->prepare("INSERT INTO products (prod_name, prod_price, prod_stock, prod_sizes, prod_color, categ_id, prod_description) VALUES (:prod_name, :prod_price, :prod_stocks, :prod_sizes, :prod_colors, :categ_id, :product_description)");

                $stmt->bindParam(':prod_name', $data['product_name']);
                $stmt->bindParam(':prod_price', $data['product_price']);
                $stmt->bindParam(':prod_stocks', $data['product_stocks']);
                $stmt->bindParam(':prod_sizes', $data['product_sizes']);
                $stmt->bindParam(':prod_colors', $data['product_colors']);
                $stmt->bindParam(':categ_id', $data['product_category']);
                $stmt->bindParam(':product_description', $data['product_description']);

                $stmt->execute();

                $productId = $this->conn->lastInsertId();

                // Insert product images into the product_images table
                $insertImageStmt = $this->conn->prepare("INSERT INTO product_images (prod_id, image_path) VALUES (:prod_id, :image_path)");

                foreach ($productImages as $imageName) {
                    $insertImageStmt->bindParam(':prod_id', $productId);
                    $insertImageStmt->bindParam(':image_path', $imageName);
                    $insertImageStmt->execute();
                }

                return ['success' => true, 'messages' => ['Product added successfully']];
            } catch (PDOException $e) {
                return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
            }
        }

        public function updateProduct($data, $files) {
            try {
                $productImages = [];
                $productImageFolder = '../public/assets/uploads/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $maxFileSize = 5000000; // 5MB limit
        
                if (isset($files['product_image']) && is_array($files['product_image']['tmp_name']) && $files['product_image']['tmp_name'][0] != '') {
                    foreach ($files['product_image']['name'] as $key => $imageName) {
                        $imageTmpName = $files['product_image']['tmp_name'][$key];
                        $imageSize = $files['product_image']['size'][$key];
                        $imageType = mime_content_type($imageTmpName);
        
                        if (!in_array($imageType, $allowedTypes)) {
                            return ['success' => false, 'messages' => ["Invalid file format for $imageName."]];
                        }
        
                        if ($imageSize > $maxFileSize) {
                            return ['success' => false, 'messages' => ["File size for $imageName exceeds the limit of 5MB."]];
                        }
        
                        $targetPath = $productImageFolder . basename($imageName);
        
                        if (!move_uploaded_file($imageTmpName, $targetPath)) {
                            return ['success' => false, 'messages' => ["Failed to upload $imageName."]];
                        }
        
                        $productImages[] = $imageName;
                    }
                } else {
                    $productImages[] = basename($data['old_images']);
                }
        
                $stmt = $this->conn->prepare("UPDATE products SET prod_name = :prod_name, prod_price = :prod_price, prod_stock = :prod_stocks, prod_sizes = :prod_sizes, prod_color = :prod_colors, categ_id = :categ_id, prod_description = :product_description WHERE prod_id = :product_id");
                $stmt->bindParam(':prod_name', $data['product_name']);
                $stmt->bindParam(':prod_price', $data['product_price']);
                $stmt->bindParam(':prod_stocks', $data['product_stocks']);
                $stmt->bindParam(':prod_sizes', $data['product_sizes']);
                $stmt->bindParam(':prod_colors', $data['product_colors']);
                $stmt->bindParam(':categ_id', $data['product_category']);
                $stmt->bindParam(':product_description', $data['product_description']);
                $stmt->bindParam(':product_id', $data['product_id']);
                $stmt->execute();
        
                $this->conn->prepare("DELETE FROM product_images WHERE prod_id = :prod_id")->execute([':prod_id' => $data['product_id']]);
        
                $insertImageStmt = $this->conn->prepare("INSERT INTO product_images (prod_id, image_path) VALUES (:prod_id, :image_path)");
                foreach ($productImages as $imageName) {
                    $insertImageStmt->bindParam(':prod_id', $data['product_id']);
                    $insertImageStmt->bindParam(':image_path', $imageName);
                    $insertImageStmt->execute();
                }
        
                return ['success' => true, 'messages' => ['Product updated successfully']];
            } catch (PDOException $e) {
                return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
            }
        }
        
        


        public function getProducts(){
            
            $sql = "SELECT P.*, C.categ_name, string_agg(I.image_path, ',') AS image_paths
            FROM products P
            JOIN category C ON P.categ_id = C.categ_id
            LEFT JOIN product_images I ON P.prod_id = I.prod_id
            GROUP BY P.prod_id, C.categ_name;"; 
            

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $products;
        }

        public function deleteProduct($data){
            
            try {
                $sql = "DELETE FROM product_images WHERE prod_id = :prod_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':prod_id', $data['product_id']);
                $stmt->execute();
            
                $sql = "DELETE FROM products WHERE prod_id = :prod_id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':prod_id', $data['product_id']);
                $stmt->execute();

            return ['success' => true, 'messages' => ['Product Deleted successfully']];
        }catch (PDOException $e) {
            return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
        }
    }

    //CATEGORY FUNCTION
    public function insertCategory($data) {
        try {
            
            // Insert product details into the products table using named placeholders
            $stmt = $this->conn->prepare("INSERT INTO category (categ_name) VALUES (:categ_name)");

            $stmt->bindParam(':categ_name', $data['categ_name']);
          
            $stmt->execute();

            $productId = $this->conn->lastInsertId();


            return ['success' => true, 'messages' => ['Category added successfully']];
        } catch (PDOException $e) {
            return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
        }
    }

    public function deleteCategory($data){
            
        try {
            $sql = "DELETE FROM category WHERE categ_id = :categ_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':categ_id', $data['categ_id']);
            $stmt->execute();
        
           
        return ['success' => true, 'messages' => ['Product Deleted successfully']];
    }catch (PDOException $e) {
        return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
    }
}

    public function getCategory(){
            
            $sql = "SELECT * FROM category";
       
        

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
    }

        //ORDER FUNCTION
        public function getOrders()
        {
            $sql = "SELECT 
                        o.order_id, 
                        c.cus_fname || ' ' || c.cus_lname AS customer_name, 
                        c.cus_phonenum AS phone, 
                        c.cus_email AS email, 
                        a.add_street || ', ' || a.add_city || ', ' || a.add_province AS address, 
                        o.order_total, 
                        p.payment_method,
                        ol.orlog_created_at AS order_date, 
                        ps.pstat_name AS payment_status,
                        os.orderstat_name AS order_status
                    FROM 
                        orders o        
                    JOIN 
                        customer c ON o.cus_id = c.cus_id
                    JOIN 
                        address a ON a.cus_id = c.cus_id
                    JOIN 
                        payment p ON o.payment_id = p.payment_id
                    JOIN 
                        payment_status ps ON o.pstat_id = ps.pstat_id
                    JOIN 
                        order_status os ON o.orderstat_id = os.orderstat_id
                    JOIN 
                        order_log ol ON o.order_id = ol.order_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    // Method to get product details for each order
    public function getOrderProductDetails($orderId)
{
    $sql = "SELECT 
                pr.prod_name,
                oi.orderi_qty
            FROM 
                order_item oi
            JOIN 
                products pr ON oi.prod_id = pr.prod_id
            WHERE 
                oi.order_id = :order_id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    
public function getOrderPending()
{
    $sql = "SELECT 
                o.order_id, 
                c.cus_fname || ' ' || c.cus_lname AS customer_name, 
                c.cus_phonenum AS phone, 
                c.cus_email AS email, 
                a.add_street || ', ' || a.add_city || ', ' || a.add_province AS address, 
                o.order_total, 
                p.payment_method,
                ol.orlog_created_at AS order_date, 
                ps.pstat_name AS payment_status,
                os.orderstat_name AS order_status
            FROM 
                orders o        
            JOIN 
                customer c ON o.cus_id = c.cus_id
            JOIN 
                address a ON a.cus_id = c.cus_id
            JOIN 
                payment p ON o.payment_id = p.payment_id
            JOIN 
                payment_status ps ON o.pstat_id = ps.pstat_id
            JOIN 
                order_status os ON o.orderstat_id = os.orderstat_id
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            WHERE 
                o.orderstat_id = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
}


public function getOrderOnDelivery()
{
    $sql = "SELECT 
                o.order_id, 
                c.cus_fname || ' ' || c.cus_lname AS customer_name, 
                c.cus_phonenum AS phone, 
                c.cus_email AS email, 
                a.add_street || ', ' || a.add_city || ', ' || a.add_province AS address, 
                o.order_total, 
                p.payment_method,
                ol.orlog_created_at AS order_date, 
                ps.pstat_name AS payment_status,
                os.orderstat_name AS order_status
            FROM 
                orders o        
            JOIN 
                customer c ON o.cus_id = c.cus_id
            JOIN 
                address a ON a.cus_id = c.cus_id
            JOIN 
                payment p ON o.payment_id = p.payment_id
            JOIN 
                payment_status ps ON o.pstat_id = ps.pstat_id
            JOIN 
                order_status os ON o.orderstat_id = os.orderstat_id
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            WHERE 
                o.orderstat_id = 2";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
}

public function updateOrderStatus($data) {

    
    try {
        $sql = "UPDATE orders SET orderstat_id = :orderstat_id WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':orderstat_id', $data['order_status']);
        $stmt->bindParam(':order_id', $data['order_id']);
        $stmt->execute();
        return ['success' => true, 'messages' => ['Order status updated successfully']];
    } catch (PDOException $e) {
        return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
    }
}

public function updateOrderStatusComplete($data) {
    $paidStatusId = 2;
    $paymentStatusUpdate = '';

    if (isset($data['payment_status']) && $data['payment_status'] == 2) {
        $paymentStatusUpdate = ", pstat_id = :pstat_id";
    }

        
    $orderStatus = $data['order_status'];

    try {
        $sql = "UPDATE orders SET orderstat_id = :orderstat_id" . $paymentStatusUpdate . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':orderstat_id', $orderStatus, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $data['order_id'], PDO::PARAM_INT);

        if ($paymentStatusUpdate) {
            $stmt->bindParam(':pstat_id', $paidStatusId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return ['success' => true, 'messages' => ['Order status updated successfully']];
    } catch (PDOException $e) {
        return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
    }
}

    }