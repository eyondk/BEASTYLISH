<?php

class OrderOnShip extends Controller
{
    public function index()
    {

        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: login'); // Adjust the path as needed for your application
            exit();
        }
        
        $order = new Order;

       
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;

           
            
            $result = $order->updateOrderStatusComplete($data);
            if ($result['success']) {
                echo json_encode(['status' => 'success', 'message' => $result['messages']]);
            } else {
                echo json_encode(['status' => 'error', 'message' => $result['messages']]);
            }
        }


       
        $orders = $order->getOrderShip();
        $data['orders'] = $orders;
        $this->view('admin/OrderOnShip', $data);
    }

    
}
