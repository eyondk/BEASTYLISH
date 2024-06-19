<?php

/**
 *  home class
 */

class Home extends Controller

{  
    
    public function index()
    {   
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
            // Redirect to the login page
            header('Location: ' . ROOT . 'login'); // Adjust the path as needed for your application
            exit();
        }
        $userId=$_SESSION['user_id'];

        $product = new UserProduct();
        $products = $product->get_latest_products();
        
        $this->view('customer/home', ['products' => $products]);
    }   
}