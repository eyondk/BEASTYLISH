<?php 
class Order extends Model
{
    protected $table = 'order';

    

     public function validateOrderStatusUpdate($paymentMethod, $paymentStatus, $newStatusString)
    {
        // Convert values to uppercase
        $paymentMethod = strtoupper($paymentMethod);
        $paymentStatus = strtoupper($paymentStatus);

        // Define disallowed methods in uppercase
        $disallowedMethods = ["GCASH", "PAYPAL", "CREDIT CARD"];

        // Check if the payment status is "UNPAID" and the payment method is disallowed
        if ($paymentStatus === "UNPAID" && in_array($paymentMethod, $disallowedMethods)) {
            return ['success' => false, 'message' => 'You cannot change the order status if the payment status is "Unpaid" and the payment method is "Gcash", "Paypal", or any credit card.'];
        }

        return ['success' => true, 'message' => ''];
    }

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

public function getOrderShip()
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
                o.orderstat_id = 2";

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
                o.orderstat_id = 3";

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
                o.orderstat_id = 4";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
}

public function getCancelled()
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
                o.orderstat_id = 5";

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