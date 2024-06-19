<?php
class CustomerOrders extends Model
{
    protected $table = 'order';

    public function getOrderPending($cusId)
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
                    o.orderstat_id = 1 AND o.cus_id = :cusId";

        

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        return $data;
    }

    public function getOrderOnShip($cusId)
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
                    o.orderstat_id = 2 AND o.cus_id = :cusId";

        

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        return $data;
    }

    public function getOrderOnDelivery($cusId)
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
                    o.orderstat_id = 3 AND o.cus_id = :cusId";

        

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        return $data;
    }

    public function getOrderComplete($cusId)
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
                    o.orderstat_id = 4 AND o.cus_id = :cusId";

        

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        return $data;
    }

    public function getOrderCancelled($cusId)
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
                    o.orderstat_id = 5 AND o.cus_id = :cusId";

        

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        return $data;
    }

    public function getOrders($cusId)
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
                    o.cus_id = :cusId";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function cancelOrder($orderId, $cusId) {
        try {
            // Start transaction
            $this->conn->beginTransaction();

            // Check if the order belongs to the customer and is pending
            $sql = "SELECT o.order_id, oi.prod_id, oi.orderi_qty
                    FROM orders o
                    JOIN order_item oi ON o.order_id = oi.order_id
                    WHERE o.order_id = :orderId AND o.cus_id = :cusId AND o.orderstat_id = 1 FOR UPDATE";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':cusId', $cusId, PDO::PARAM_INT);
            $stmt->execute();
            $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($orderItems)) {
                throw new Exception('Order not found or not eligible for cancellation');
            }

            // Update stock quantity
            foreach ($orderItems as $item) {
                $sql = "UPDATE products SET prod_stock = prod_stock + :qty WHERE prod_id = :prodId";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':qty', $item['orderi_qty'], PDO::PARAM_INT);
                $stmt->bindParam(':prodId', $item['prod_id'], PDO::PARAM_INT);
                $stmt->execute();
            }

            // Update order status to cancelled (assuming 5 is the cancelled status)
            $sql = "UPDATE orders SET orderstat_id = 5 WHERE order_id = :orderId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();

            // Commit transaction
            $this->conn->commit();

            return ['success' => true, 'message' => 'Order cancelled successfully'];
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
