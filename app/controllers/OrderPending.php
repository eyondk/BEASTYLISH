<?php

class OrderPending extends Controller
{
    public function index()
    {

        $order = new Order;

      
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $_POST;

            $paymentMethod = $data['payment_method'];
            $paymentStatus = $data['payment_status'];
            $newStatusString = $data['order_status'];

        
            $validationResult = $order->validateOrderStatusUpdate($paymentMethod, $paymentStatus, $newStatusString);

            if (!$validationResult['success']) {
                echo json_encode(['status' => 'error', 'message' => $validationResult['message']]);
                return;
            }
            
            $result = $order->updateOrderStatus($data);
            if ($result['success']) {
                echo json_encode(['status' => 'success', 'message' => $result['messages']]);
            } else {
                echo json_encode(['status' => 'error', 'message' => $result['messages']]);
            }
        }


       
        $orders = $order->getOrderPending();
        $data['orders'] = $orders;
        $this->view('admin/OrderPending', $data);
    }

    
}
