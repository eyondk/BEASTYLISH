<?php 
class Customers extends Model
{
    protected $table = 'customer';

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

}