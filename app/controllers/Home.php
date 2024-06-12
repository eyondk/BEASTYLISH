<?php

class Home extends Controller
{
    public function index()
    {
        // Check if the user is logged in
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email']) || !isset($_SESSION['user_type'])) {
            // User is not logged in, redirect to the login page
            header('Location: ' . ROOT . '/login');
            exit();
        }

        // Fetch user details based on the user type
        // if ($_SESSION['user_type'] === 'CUSTOMER') {
        //     $customerModel = new Customer();
        //     $user = $customerModel->getById($_SESSION['user_id']);
        // } elseif ($_SESSION['user_type'] === 'ADMIN') {
        //     $adminModel = new Admin();
        //     $user = $adminModel->getById($_SESSION['user_id']);
        // }

        // Pass user data to the view
        // $this->view('account', ['user' => $user]);
        $this->view('home');
    }
}

?>
