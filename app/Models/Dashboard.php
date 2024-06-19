<?php 
class Dashboard extends Model
{
    protected $table = 'order';

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
        $sql = "SELECT COALESCE(SUM(oi.orderi_qty * p.prod_price), 0) AS total_revenue, COALESCE(SUM(oi.orderi_qty), 0) AS total_qty
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
    

}