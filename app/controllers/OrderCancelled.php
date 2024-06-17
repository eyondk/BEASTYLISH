<?php

class OrderCancelled extends Controller
{
    public function index()
    {

        $order = new Order;

       
       
       

       
        $orders = $order->getCancelled();
        $data['orders'] = $orders;
        $this->view('admin/OrderCancelled', $data);
    }

    
}
