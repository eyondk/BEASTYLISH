<?php

/**
 *  contact class
 */

class Contact extends Controller

{  
    
    public function index()
    {   
        if (isset($_SESSION['timeout']) && isset($_SESSION['last_activity'])) {
           
            if (time() - $_SESSION['last_activity'] > $_SESSION['timeout']) {
               
                session_unset(); 
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
        $this->view('customer/contact');
    }   
}