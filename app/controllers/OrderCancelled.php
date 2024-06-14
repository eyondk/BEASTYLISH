<?php

class OrderCancelled extends Controller
{
    public function index()
    {

        $order = new Order;

       
       
       

       
        $orders = $order->getOrderCancelled();
        $data['orders'] = $orders;
        $this->view('admin/rderComplete', $data);
    }

    
}
