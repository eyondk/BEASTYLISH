<?php

/**
 *  home class
 */

class Home extends Controller

{  
    
    public function index()
    {   
        if (isset($_SESSION['timeout']) && isset($_SESSION['last_activity'])) {
           
            if (time() - $_SESSION['last_activity'] > $_SESSION['timeout']) {
             
                session_unset(); 
                session_destroy(); 
                header('Location: ' . ROOT . '/login');
                exit();
            } else {
                // Update last activity time
                $_SESSION['last_activity'] = time();
            }
        } else {
            
            $_SESSION['timeout'] = 1800; 
            $_SESSION['last_activity'] = time();
        }
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