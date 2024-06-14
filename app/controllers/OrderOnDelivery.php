<?php

class OrderOnDelivery extends Controller
{
    public function index()
    {

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


       
        $orders = $order->getOrderOnDelivery();
        $data['orders'] = $orders;
        $this->view('admin/OrderOnDelivery', $data);
    }

    
}
