<?php

class AdminCustomer extends Controller
{

    public function index()
    {
         if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: home/login'); // Adjust the path as needed for your application
            exit();
        }
        
        $cus = new Customers;
        $data['orders'] = $cus->getCustomerOrders();
        $this->view('admin/Customer',$data);
    }

}
