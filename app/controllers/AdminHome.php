<?php

class AdminHome extends Controller
{

    public function index()
    {

        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: home/login'); // Adjust the path as needed for your application
            exit();
        }
        $dash = new Dashboard;

        $total_sales_result = $dash->getTotalSales();
        $total_revenue_result = $dash->getTotalRevenue();
        $today_sales_result = $dash->getTodaySales();
        $today_revenue_result = $dash->getTodayRevenue();

       
        $monthly_sales_result = $dash->getMonthlyTotalSales();
        $monthly_revenue_result = $dash->getMonthlyTotalRevenue();
        $weekly_sales = $dash->getWeeklySales();
        $weekly_revenue = $dash->getWeeklyRevenue();
        $topproducts = $dash->getTopProducts(10);
       

        $data['top_products'] = $topproducts;
        $data['weekly_sales'] = $weekly_sales;
        $data['weekly_revenue'] = $weekly_revenue;
        $data['monthly_sales'] = $monthly_sales_result;
        $data['monthly_revenue'] = $monthly_revenue_result;
        $data['total_sales'] = $total_sales_result['total_sales'];
        $data['total_revenue'] = $total_revenue_result['total_revenue'];
        $data['today_sales'] = $today_sales_result['today_sales'];
        $data['today_revenue'] = $today_revenue_result['today_revenue'];

       
        
        $this->view("admin/adminhome",$data);

    }

    public function logout() {
            
        // Unset all of the session variables
        $_SESSION = array();
        
        // Destroy the session
        session_destroy();
        
        // Redirect to the login page or any other desired page
        header("Location:" .ROOT. "/login?logout=success");
        exit();
    }

}       

