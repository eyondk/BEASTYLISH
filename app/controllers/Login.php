<?php

// Require Composer's autoloader
require_once ( '../public/vendor/autoload.php');

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
                $addressModel = new AddressModel();


                $customer = $customerModel->getByEmail($email);
                $admin = $adminModel->getByEmail($email);

                        


                if ($customer) {
                    $saltedPassword = $customer->cus_passwordsalt . $password;

                    if (password_verify($saltedPassword, $customer->cus_passwordhash)) {

                        $address = $addressModel->getByCustomerId($customer->cus_id);

                        // echo '<pre>';
                        // print_r($address);
                        // echo '</pre>';
                        

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
                        

                        if ($address) {
                            $_SESSION['user_street'] = $address[0]->add_street;
                            $_SESSION['user_city'] = $address[0]->add_city;
                            $_SESSION['user_province'] = $address[0]->add_province;
                            $_SESSION['user_infoaddress'] = $address[0]->add_infoaddress;
                        } else {
                            $_SESSION['user_street'] = null;
                            $_SESSION['user_city'] = null;
                            $_SESSION['user_province'] = null;
                            $_SESSION['user_infoaddress'] = null;
                        }



                        // Debugging output
                        
                        
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
                        $_SESSION['user_phonenumber'] = $admin->admin_phonenum;
                        $_SESSION['user_profile'] = $admin->admin_profile;
                        $_SESSION['user_sex'] = $admin->admin_sex;


                      
                            $_SESSION['user_street'] = null;
                            $_SESSION['user_city'] = null;
                            $_SESSION['user_province'] = null;
                            $_SESSION['user_infoaddress'] = null;
                        

                       

                        header('Location: ' . ROOT . '/adminAccount');
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
    

    

    public function requestReset() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Invalid email address.';
                $this->view('login', ['message' => $message]);
                return;
            }
    
            $customerModel = new Customer();
            $user = $customerModel->getByEmail($email);
    
            if ($user) {
                $resetToken = bin2hex(random_bytes(32));
                $resetExpiry = (new DateTime('now', new DateTimeZone('Asia/Kuala_Lumpur')))->modify('+1 hour')->format('Y-m-d H:i:s');
    
                error_log("Generated token: $resetToken");
                error_log("Expiry time: $resetExpiry");

                $_SESSION['reset_token'] = $resetToken;
                $_SESSION['reset_expiry'] = $resetExpiry;
    
                if ($customerModel->updateResetToken($user->cus_id, $resetToken, $resetExpiry)) {
                    if ($this->sendResetEmail($email, $resetToken)) {
                        $message = 'Password reset email has been sent.';
                    } else {
                        $message = 'Failed to send reset email.';
                    }
                } else {
                    $message = 'Failed to update reset token.';
                }
            } else {
                $message = 'Email address not found.';
            }
    
            $this->view('login', ['message' => $message]);
        }
    }
    




    private function sendResetEmail($toEmail, $resetToken) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            // $mail->SMTPDebug = 2; 
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'fishball.12h@gmail.com';                     // SMTP username
            $mail->Password   = 'gsxs barx gapl alpi';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                    // TCP port to connect to

             // Add SMTPOptions to disable SSL verification
            //  $mail->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            //     )
            // );
            
            //Recipients
            $mail->setFrom('fishball.12h@gmail.com', "Be'astylish");
            $mail->addAddress($toEmail);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "You requested a password reset. Click the link below to reset your password:<br>";
            $mail->Body   .= "<a href='" . ROOT . "/reset?token=" . $resetToken . "'>Reset Password</a>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
    
    
    public function resetPassword() {
        date_default_timezone_set('Asia/Kuala_Lumpur');
        global $conn;
        $customerModel = new Customer($conn);
        $message = '';
    
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['reset_token'])) {
            $token = filter_var($_SESSION['reset_token'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            unset($_SESSION['reset_token']);
            unset($_SESSION['reset_expiry']);
            
            $customerModel = new Customer();
            $user = $customerModel->getByToken($token);
    
            if ($user) {
                $currentTimestamp = time();
                $resetExpiryTimestamp = strtotime($user->cus_resetexpired);
    
                // echo '<pre>';
                // echo "Token: $token\n";
                // echo "Current Time: " . date('Y-m-d H:i:s', $currentTimestamp) . "\n";
                // echo "Reset Expired Time: " . $user->cus_resetexpired . "\n";
                // echo '</pre>';
    
                $this->view('resetPassword', [
                    'token' => $token,
                    'current_time' => date('Y-m-d H:i:s', $currentTimestamp),
                    'reset_expired_time' => $user->cus_resetexpired
                ]);
                return;
            }
            $message = "Invalid or expired token.";
            $this->view('login', ['message' => $message]);
    
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
            $token = filter_var($_POST['token'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // echo "Token from POST request: " . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . "<br>"; // Debugging output
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
    
            if ($password === $confirm_password) {
                $user = $customerModel->getByToken($token);
    
                // echo '<pre>';
                // print_r('user:');
                // print_r($user);
                // echo '</pre>';
    
                if ($user) {
                    $currentTimestamp = time();
                    $resetExpiryTimestamp = strtotime($user['cus_resetexpired']);
    
                    if ($resetExpiryTimestamp > $currentTimestamp) {
                        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
                            $message = "Password must be at least 8 characters long and include a mix of uppercase, lowercase, and numeric characters.";
                        } else {
                            $salt = bin2hex(random_bytes(32));
                            $saltedPassword = $salt . $password;
                            $passwordHash = password_hash($saltedPassword, PASSWORD_BCRYPT);
    
                            if ($customerModel->updatePassword($user['cus_id'], $passwordHash, $salt)) {
                                $message = "Password reset successfully.";
                            } else {
                                $message = "Failed to reset password.";
                            }
                        }
                    } else {
                        $message = "Invalid or expired token.";
                    }
                } else {
                    $message = "Invalid or expired token.";
                }
            } else {
                $message = "Passwords do not match.";
            }
    
            $this->view('login', ['message' => $message]);
        }
    }
    
    // public function resetPassword($token, $newPassword) {
    //     $customer = $this->getByToken($token);
    
    //     if ($customer) {
    //         $expiryTime = strtotime($customer->CUS_RESETEXPIRED);
    //         $currentTime = time();
    
    //         echo "Current time: " . date('Y-m-d H:i:s', $currentTime) . "<br>";
    //         echo "Expiry time: " . date('Y-m-d H:i:s', $expiryTime) . "<br>";
    
    //         if ($expiryTime > $currentTime) {
    //             $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
    //             $this->updatePassword($customer->CUS_ID, $passwordHash, $customer->CUS_PASSWORDSALT);
    //             return true;
    //         } else {
    //             echo "Token has expired.<br>";
    //         }
    //     } else {
    //         echo "Invalid token.<br>";
    //     }
    //     return false;
    // }
    
    
    
    
    
    
    
    
    

}
