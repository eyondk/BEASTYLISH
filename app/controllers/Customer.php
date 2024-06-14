<?php

class Customer extends Controller
{

    public function index()
    {
        print_r($_POST);
        $cus = new Customers;
        $data['orders'] = $cus->getCustomerOrders();
        $this->view('admin/Customer',$data);
    }

}
