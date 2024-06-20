<?php

/**
 *  about class
 */

class About extends Controller

{  
    
    public function index()
    {   
        if (isset($_SESSION['timeout']) && isset($_SESSION['last_activity'])) {
            // Check if the session has timed out
            if (time() - $_SESSION['last_activity'] > $_SESSION['timeout']) {
                // Session has timed out, destroy the session and redirect to the login page
                session_unset(); // Unset all session variables
                session_destroy(); // Destroy the session
                header('Location: ' . ROOT . '/login');
                exit();
            } else {
                // Update last activity time
                $_SESSION['last_activity'] = time();
            }
        } else {
            // If timeout and last activity are not set, set them
            $_SESSION['timeout'] = 1800; // 1800 seconds = 30 minutes
            $_SESSION['last_activity'] = time();
        }
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email']) || !isset($_SESSION['user_type'])) {
            // User is not logged in, redirect to the login page
            header('Location: ' . ROOT . '/login');
            exit();
        }
        // $model = new Model;
        // $model -> test();
      
     
        
        $this->view('customer/about');
    }   
}