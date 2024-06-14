    <?php
    class Model extends Database {
        public function __construct() {
            $this->conn = $this->connect();
        }

        //CUSTOMER

        public function getCustomerOrders() {
            $sql = "
                SELECT 
                    c.cus_id, 
                    c.cus_fname, 
                    c.cus_lname, 
                    CONCAT(a.add_street, ', ', a.add_city, ', ', a.add_province, COALESCE(', ' || a.add_infoaddress, '')) AS customer_address,
                    COUNT(DISTINCT o.order_id) AS orders_count, 
                    COALESCE(SUM(oi.orderi_qty * p.prod_price), 0) AS total_spent
                FROM 
                    customer c
                LEFT JOIN 
                    orders o ON c.cus_id = o.cus_id
                LEFT JOIN 
                    address a ON c.cus_id = a.cus_id
                LEFT JOIN 
                    order_item oi ON o.order_id = oi.order_id
                LEFT JOIN 
                    products p ON oi.prod_id = p.prod_id
                GROUP BY 
                    c.cus_id, c.cus_fname, c.cus_lname, customer_address
                ORDER BY 
                    c.cus_id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

        
        public function getCustomerDetailsById($cus_id)
        {
            try {
                // Fetch customer details with orders and total spent
                $sql = "
                    SELECT 
                        c.cus_id, 
                        c.cus_fname, 
                        c.cus_lname, 
                        c.cus_username,
                        c.cus_email,
                        c.cus_phonenum,
                        CONCAT(a.add_street, ', ', a.add_city, ', ', a.add_province, COALESCE(', ' || a.add_infoaddress, '')) AS customer_address,
                        COUNT(DISTINCT o.order_id) AS orders_count, 
                        COALESCE(SUM(oi.orderi_qty * p.prod_price), 0) AS total_spent
                    FROM 
                        customer c
                    LEFT JOIN 
                        orders o ON c.cus_id = o.cus_id
                    LEFT JOIN 
                        address a ON c.cus_id = a.cus_id
                    LEFT JOIN 
                        order_item oi ON o.order_id = oi.order_id
                    LEFT JOIN 
                        products p ON oi.prod_id = p.prod_id
                    WHERE 
                        c.cus_id = :cus_id
                    GROUP BY 
                        c.cus_id, c.cus_fname, c.cus_lname, c.cus_username, c.cus_email, c.cus_phonenum, customer_address
                    ORDER BY 
                        c.cus_id";
            
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':cus_id', $cus_id, PDO::PARAM_INT);
                $stmt->execute();
                $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($customer === false) {
                    return ['success' => false, 'message' => 'Customer not found'];
                }
        
                return [
                    'success' => true,
                    'data' => [
                        'customer' => $customer,
                        'total_orders' => $customer['orders_count'],
                        'total_spent' => $customer['total_spent']
                    ]
                ];
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
            }
        }
        




   


        //PRODUCT FUNCTION
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

    public function hasProducts($categ_id) {
        $sql = "SELECT COUNT(*) as count FROM products WHERE categ_id = :categ_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':categ_id', $categ_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    

    public function deleteCategory($data) {
        try {
            // Check if the category has associated products
            $checkResult = $this->checkForProducts($data['categ_id']);
            if ($checkResult['hasProducts']) {
                return ['success' => false, 'messages' => ['This category cannot be deleted because there are associated products.']];
            }
    
            // Proceed to delete the category
            $sql = "DELETE FROM category WHERE categ_id = :categ_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':categ_id', $data['categ_id']);
            $stmt->execute();
    
            return ['success' => true, 'messages' => ['Category deleted successfully']];
        } catch (PDOException $e) {
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
                    LEFT JOIN 
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
            LEFT JOIN 
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

public function getOrderComplete()
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
                o.orderstat_id = 3";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
}

public function getOrderCancelled()
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
                o.orderstat_id = 4";

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

//DASHBOARD
public function getTotalSales() {
    $sql = "SELECT COUNT(DISTINCT o.order_id) AS total_sales 
            FROM orders o
            JOIN order_log ol ON o.order_id = ol.order_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

public function getTotalRevenue() {
    $sql = "SELECT SUM(oi.orderi_qty * p.prod_price) AS total_revenue, SUM(oi.orderi_qty) AS total_qty
            FROM orders o
            JOIN order_log ol ON o.order_id = ol.order_id
            JOIN order_item oi ON o.order_id = oi.order_id
            JOIN products p ON oi.prod_id = p.prod_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

public function getTodaySales() {
    $sql = "SELECT COUNT(DISTINCT o.order_id) AS today_sales 
            FROM orders o
            JOIN order_log ol ON o.order_id = ol.order_id
            WHERE DATE(ol.orlog_created_at) = CURRENT_DATE";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

public function getTodayRevenue() {
    $sql = "SELECT COALESCE(SUM(oi.orderi_qty * p.prod_price), 0) AS today_revenue,
                   COALESCE(SUM(oi.orderi_qty), 0) AS today_qty
            FROM orders o
            JOIN order_log ol ON o.order_id = ol.order_id
            JOIN order_item oi ON o.order_id = oi.order_id
            JOIN products p ON oi.prod_id = p.prod_id
            WHERE DATE(ol.orlog_created_at) = CURRENT_DATE";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

public function getWeeklySales() {
    $sql = "SELECT 
                DATE_TRUNC('week', ol.orlog_created_at) AS week, 
                COUNT(DISTINCT o.order_id) AS total_sales
            FROM 
                orders o
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            GROUP BY 
                week
            ORDER BY 
                week";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

public function getWeeklyRevenue() {
    $sql = "SELECT 
                DATE_TRUNC('week', ol.orlog_created_at) AS week, 
                SUM(oi.orderi_qty * p.prod_price) AS total_revenue,
                SUM(oi.orderi_qty) AS total_qty
            FROM 
                orders o
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            JOIN 
                order_item oi ON o.order_id = oi.order_id
            JOIN 
                products p ON oi.prod_id = p.prod_id
            GROUP BY 
                week
            ORDER BY 
                week";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



public function getMonthlyTotalSales() {
    $sql = "SELECT 
                DATE_TRUNC('month', ol.orlog_created_at) AS month, 
                COUNT(DISTINCT o.order_id) AS total_sales
            FROM 
                orders o
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            GROUP BY 
                month
            ORDER BY 
                month";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

public function getMonthlyTotalRevenue() {
    $sql = "SELECT 
                DATE_TRUNC('month', ol.orlog_created_at) AS month, 
                SUM(oi.orderi_qty * p.prod_price) AS total_revenue,
                SUM(oi.orderi_qty) AS total_qty
            FROM 
                orders o
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            JOIN 
                order_item oi ON o.order_id = oi.order_id
            JOIN 
                products p ON oi.prod_id = p.prod_id
            GROUP BY 
                month
            ORDER BY 
                month";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

public function getTopProducts($limit = 10) {
    try {
     
        $sql = "SELECT 
                    p.prod_id, 
                    p.prod_name, 
                    SUM(oi.orderi_qty) AS total_sales, 
                    SUM(oi.orderi_qty * pr.prod_price) AS total_revenue
                FROM 
                    order_item oi
                JOIN 
                    products p ON oi.prod_id = p.prod_id
                JOIN 
                    orders o ON oi.order_id = o.order_id
                JOIN 
                    products pr ON oi.prod_id = pr.prod_id
                GROUP BY 
                    p.prod_id, p.prod_name
                ORDER BY 
                    total_sales DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
    }
}

//REPORTS
public function getWeeklyReportSales() {
    $sql = "SELECT 
                DATE_TRUNC('month', ol.orlog_created_at) AS month, 
                EXTRACT(YEAR FROM ol.orlog_created_at) AS year,
                DATE_TRUNC('week', ol.orlog_created_at) AS week, 
                p.prod_name, 
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 1 THEN oi.orderi_qty ELSE 0 END) AS mon,
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 2 THEN oi.orderi_qty ELSE 0 END) AS tue,
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 3 THEN oi.orderi_qty ELSE 0 END) AS wed,
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 4 THEN oi.orderi_qty ELSE 0 END) AS thu,
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 5 THEN oi.orderi_qty ELSE 0 END) AS fri,
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 6 THEN oi.orderi_qty ELSE 0 END) AS sat,
                SUM(CASE WHEN EXTRACT(DOW FROM ol.orlog_created_at) = 0 THEN oi.orderi_qty ELSE 0 END) AS sun,
                SUM(oi.orderi_qty) AS total
            FROM 
                order_item oi
            JOIN 
                products p ON oi.prod_id = p.prod_id
            JOIN 
                orders o ON oi.order_id = o.order_id
            JOIN 
                order_log ol ON o.order_id = ol.order_id
            GROUP BY 
                month, year, week, p.prod_name
            ORDER BY 
                month, week, p.prod_name";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


}



    