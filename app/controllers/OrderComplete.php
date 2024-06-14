<?php

class OrderComplete extends Controller
{
    public function index()
    {

        $order = new Order;

       
       
       

       
        $orders = $order->getOrderComplete();
        $data['orders'] = $orders;
        $this->view('admin/OrderComplete', $data);
    }

    
}
