<?php

class Orders extends Controller
{
    public function index()
    {

        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
           
            header('Location: login'); 
            exit();
        }
        $order = new Order;

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
            $this->getOrderDetails($order);
        } else {
            $orders = $order->getOrders();
            $data['orders'] = $orders;
            $this->view('admin/Orders', $data);
        }
    }

    private function getOrderDetails($order)
    {
        header('Content-Type: application/json');  
        try {
            if (isset($_POST['orderId'])) {
                $orderId = $_POST['orderId'];
                $details = $order->getOrderProductDetails($orderId);
                echo json_encode($details);
            } else {
                echo json_encode(['error' => 'Order ID is required']);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit(); 
    }
}
