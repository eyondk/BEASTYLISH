<?php

/**
 *  contact class
 */

class Contact extends Controller

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
        $this->view('customer/contact');
    }   
}