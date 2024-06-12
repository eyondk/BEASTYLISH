<?php

// Require Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Login extends Controller {

    public function index() {
        $this->view('login');
    }

   
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!empty($email) && !empty($password)) {
                $customerModel = new Customer();
                $adminModel = new Admin();

                $customer = $customerModel->getByEmail($email);
                $admin = $adminModel->getByEmail($email);

                if ($customer) {
                    $saltedPassword = $customer->cus_passwordsalt . $password;

                    if (password_verify($saltedPassword, $customer->cus_passwordhash)) {
                        $_SESSION['user_id'] = $customer->cus_id;
                        $_SESSION['user_email'] = $customer->cus_email;
                        $_SESSION['user_fname'] = $customer->cus_fname;
                        $_SESSION['user_lname'] = $customer->cus_lname;
                        $_SESSION['user_username'] = $customer->cus_username;
                        $_SESSION['user_phonenumber'] = $customer->cus_phonenum;
                        $_SESSION['user_sex'] = $customer->cus_sex;
                        $_SESSION['user_profile'] = $customer->cus_profile;
                        $_SESSION['user_passwordhash'] = $customer->cus_passwordhash;
                        $_SESSION['user_passwordsalt'] = $customer->cus_passwordsalt;
                        $_SESSION['user_type'] = 'CUSTOMER';




                        // Debugging output
                        // echo '<pre>';
                        // print_r($customer);
                        // echo '</pre>';
                        // exit();

                        
                        header('Location: ' . ROOT . '/home');
                        exit();
                    } else {
                        $message = "Invalid email or password.";
                        $this->view('login', ['message' => $message]);
                    }
                } elseif ($admin) {
                    $saltedPassword = $admin->admin_passwordsalt . $password;

                    if (password_verify($saltedPassword, $admin->admin_passwordhash)) {
                        $_SESSION['user_id'] = $admin->admin_id;
                        $_SESSION['user_email'] = $admin->admin_email;
                        $_SESSION['user_type'] = 'ADMIN';
                        $_SESSION['user_fname'] = $admin->admin_fname;
                        $_SESSION['user_lname'] = $admin->admin_lname;
                        $_SESSION['user_username'] = $admin->admin_username;
                        $_SESSION['user_phone'] = $admin->admin_phone;
                        $_SESSION['user_profile'] = $admin->admin_profile;
                        $_SESSION['user_sex'] = $admin->admin_sex;
                        $_SESSION['user_address'] = $admin->admin_address;
                        $_SESSION['user_city'] = $admin->admin_city;
                        $_SESSION['user_province'] = $admin->admin_province;

                        header('Location: ' . ROOT . '/dashboard');
                        exit();
                    } else {
                        $message = "Invalid email or password.";
                        $this->view('login', ['message' => $message]);
                    }
                } else {
                    $message = "Invalid email or password.";
                    $this->view('login', ['message' => $message]);
                }
            } else {
                $message = "Email and password are required.";
                $this->view('login', ['message' => $message]);
            }
        } else {
            header('Location: ' . ROOT . '/login');
            exit();
        }
    }
    

    //naay logic error
    public function requestReset() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
    
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Invalid email address.';
                $this->view('login', ['message' => $message]);
                return;
            }
    
            // Instantiate the Customer model
            $customerModel = new Customer();
    
            // Attempt to find the user by email
            $user = $customerModel->getByEmail($email);
    
            // Check if user exists
            if ($user) {
                // Generate a reset token and expiration
                $resetToken = bin2hex(random_bytes(32));
                $resetExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
                // Update user record with reset token and expiry
                $updateSuccess = $customerModel->updateResetToken($user->cus_id, $resetToken, $resetExpiry);
              
    
                if ($updateSuccess) {
                    // Send reset email
                    $this->sendResetEmail($email, $resetToken);
                    $message = 'Password reset email has been sent.';
                } else {
                    $message = 'Failed to update reset token.';
                }
    
                $this->view('login', ['message' => $message]);
            } else {
                $message = 'Email address not found.';
                $this->view('login', ['message' => $message]);
            }
        }
    }
    

    //dili pa working
    function sendResetEmail($email, $token) {
        $mail = new PHPMailer(true); 

        try {
            // Server settings
            $mail->isSMTP();                                        // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                 // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = '';           // SMTP username
            $mail->Password   = '';              // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                // TCP port to connect to

            // Recipients
            $mail->setFrom('fishbal.12h@gmail.com', 'Beastylish');
            $mail->addAddress($email);                             // Add a recipient

            // Content
            $mail->isHTML(true);                                   // Set email format to HTML
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = 'Click on the following link to reset your password: <a href="' . ROOT . '/reset.php?token=' . $token . '">Reset Password</a>';
            $mail->AltBody = 'Copy and paste this URL to reset your password: ' . ROOT . '/reset.php?token=' . $token;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}


