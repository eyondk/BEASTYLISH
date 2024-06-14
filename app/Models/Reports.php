<?php 
class Reports extends Model
{
    protected $table = 'orders';

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