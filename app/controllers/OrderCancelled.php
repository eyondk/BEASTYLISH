<?php

class OrderCancelled extends Controller
{
    public function index()
    {

        $order = new Order;

       
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: login'); // Adjust the path as needed for your application
            exit();
        }
       

       
        $orders = $order->getCancelled();
        $data['orders'] = $orders;
        $this->view('admin/OrderCancelled', $data);
    }

    
}
