<?php
class Policy extends Controller{

public function index(){

    if (isset($_SESSION['timeout']) && isset($_SESSION['last_activity'])) {
        // Check if the session has timed out
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
        // If timeout and last activity are not set, set them
        $_SESSION['timeout'] = 1800; // 1800 seconds = 30 minutes
        $_SESSION['last_activity'] = time();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
        // Redirect to the login page
        header('Location: home/login'); // Adjust the path as needed for your application
        exit();
    }
    $this->view("customer/policy");
}
}