// <?php

// class SignUp extends Controller {
//     public function index() {
//         $this->view("signup");
//     }

//     public function register() {
//         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//             $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//             $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//             $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//             $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
//             $phonenum = filter_input(INPUT_POST, 'phonenum', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//             $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//             $password = $_POST['password'];
//             $cpassword = $_POST['cpassword'];
            
//             $image = $_FILES['image'];
//             $image_name = $image['name'];
//             $image_tmp_name = $image['tmp_name'];
//             $image_error = $image['error'];

//             $message = [];

//             // Validate
//             if ($password !== $cpassword) {
//                 $message[] = 'Passwords do not match';
//                 error_log('Validation error: Passwords do not match');
//                 return $this->view("signup", ['message' => $message]);
//             }

//             if ($image_error !== UPLOAD_ERR_OK) {
//                 $message[] = 'Please upload a valid image';
//                 error_log('Validation error: Please upload a valid image');
//                 return $this->view("signup", ['message' => $message]);
//             } else {
//                 $image_size = $image['size'];
//                 if ($image_size > 20000000) { // 20MB limit
//                     $message[] = 'Image is too large (maximum 20MB allowed)';
//                     error_log('Validation error: Image is too large (maximum 20MB allowed)');
//                     return $this->view("signup", ['message' => $message]);
//                 }
//             }

//             $customerModel = new Customer();
//             $adminModel = new Admin();

//             // Check if email or phone number is already registered
//             if ($customerModel->getByEmail($email) || $adminModel->getByEmail($email)) {
//                 $message[] = 'Email address is already registered';
//                 error_log('Validation error: Email address is already registered');
//             }

//             if ($customerModel->getByPhone($phonenum) || $adminModel->getByPhone($phonenum)) {
//                 $message[] = 'Phone number is already registered';
//                 error_log('Validation error: Phone number is already registered');
//             }

//             if ($adminModel->getByUsername($username) || $customerModel->getByUsername($username)) {
//                 $message[] = 'Username is already taken';
//                 error_log('Validation error: Username is already taken');
//             }

//             if (stripos($username, 'admin') !== false) {


//                 if (empty($message)) {
//                     $upload_dir = __DIR__ . '/../../public/assets/uploaded_img/';
//                     $image_path = $upload_dir . $image_name;

//                     if (!file_exists($upload_dir)) {
//                         if (!mkdir($upload_dir, 0777, true)) {
//                             $message[] = 'Failed to create directory for image upload';
//                             error_log('Error: Failed to create directory for image upload');
//                             return $this->view("signup", ['message' => $message]);
//                         }
//                     }

//                     if (!move_uploaded_file($image_tmp_name, $image_path)) {
//                         $message[] = 'Failed to upload image';
//                         error_log('Error: Failed to upload image');
//                         return $this->view("signup", ['message' => $message]);
//                     }

//                     $salt = bin2hex(random_bytes(16));
//                     $saltedPassword = $salt . $password;
//                     $passwordHash = password_hash($saltedPassword, PASSWORD_DEFAULT);


//                     $adminData = [
//                         'admin_fname' => $fname,
//                         'admin_lname' => $lname,
//                         'admin_email' => $email,
//                         'admin_username' => $username,
//                         'admin_passwordhash' => $passwordHash,
//                         'admin_passwordsalt' => $salt,
//                         'admin_profile' => '/assets/uploaded_img/' . $image_name,
//                         'admin_sex' => $sex,
//                         'admin_phonenum' => $phonenum
//                     ];

//                     if ($adminModel->insert($adminData)) {
//                         header('Location: ' . ROOT . '/login');
//                         exit();
//                     } else {
//                         $message[] = 'Error occurred while signing up. Please try again later.';
//                         error_log('Database error: Error occurred while signing up as admin');
//                         return $this->view("signup", ['message' => $message]);
//                     }
//                 }
//             } else {

//                 if (empty($message)) {
//                     $upload_dir = __DIR__ . '/../../public/assets/uploaded_img/';
//                     $image_path = $upload_dir . $image_name;

//                     if (!file_exists($upload_dir)) {
//                         if (!mkdir($upload_dir, 0777, true)) {
//                             $message[] = 'Failed to create directory for image upload';
//                             error_log('Error: Failed to create directory for image upload');
//                             return $this->view("signup", ['message' => $message]);
//                         }
//                     }

//                     if (!move_uploaded_file($image_tmp_name, $image_path)) {
//                         $message[] = 'Failed to upload image';
//                         error_log('Error: Failed to upload image');
//                         return $this->view("signup", ['message' => $message]);
//                     }

//                     $salt = bin2hex(random_bytes(16));
//                     $saltedPassword = $salt . $password;
//                     $passwordHash = password_hash($saltedPassword, PASSWORD_DEFAULT);

//                     $data = [
//                         'CUS_FNAME' => $fname,
//                         'CUS_LNAME' => $lname,
//                         'CUS_USERNAME' => $username,
//                         'CUS_EMAIL' => $email,
//                         'CUS_PASSWORDHASH' => $passwordHash,
//                         'CUS_PASSWORDSALT' => $salt,
//                         'CUS_PROFILE' => '/assets/uploaded_img/' . $image_name,
//                         'CUS_PHONENUM' => $phonenum,
//                         'CUS_SEX' => $sex
//                     ];

                    
//                     // Insert customer data
//                     $cus_id = $customerModel->insertCustomer($data);

//                     if ($cus_id) {
//                         $_SESSION['temp_cus_id'] = $cus_id;
//                         header('Location: ' . ROOT . '/address');
//                         exit();
//                     } else {
//                         $message[] = 'Error occurred while signing up. Please try again later.';
//                         error_log('Database error: Error occurred while signing up');
//                         return $this->view("signup", ['message' => $message]);
//                     }
//                 }
//             }

//             return $this->view("signup", ['message' => $message]);
//         }
//     }
// }

//?>


<?php
require_once '../public/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class SignUp extends Controller {
    
    // public function __construct() {
    //     if (session_status() == PHP_SESSION_NONE) {
    //         session_start();
    //     }
    // }

    public function index() {
        $this->view("signup");
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phonenum = filter_input(INPUT_POST, 'phonenum', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            $image = $_FILES['image'];


            $message = [];

            // Validate
            if ($password !== $cpassword) {
                $message[] = 'Passwords do not match';
                return $this->view("signup", ['message' => $message]);
            }

            if ($image['error'] !== UPLOAD_ERR_OK) {
                $message[] = 'Please upload a valid image';
                return $this->view("signup", ['message' => $message]);
            } else {
                $image_size = $image['size'];
                if ($image_size > 20000000) { // 20MB limit
                    $message[] = 'Image is too large (maximum 20MB allowed)';
                    return $this->view("signup", ['message' => $message]);
                }
            }

            $customerModel = new Customer();
            $adminModel = new Admin();

            // Check if email or phone number is already registered
            if ($customerModel->getByEmail($email) || $adminModel->getByEmail($email)) {
                $message[] = 'Email address is already registered';
            }

            if ($customerModel->getByPhone($phonenum) || $adminModel->getByPhone($phonenum)) {
                $message[] = 'Phone number is already registered';
            }

            if ($adminModel->getByUsername($username) || $customerModel->getByUsername($username)) {
                $message[] = 'Username is already taken';
            }

            // Generate OTP verification code
            $otpVerificationCode = rand(100000, 999999);

            // Send verification email
            if ($this->sendVerificationEmail($email, $otpVerificationCode)) {
                // Store registration data in session to complete registration after OTP verification
                $_SESSION['otp_verification_code'] = (string)$otpVerificationCode;
                $_SESSION['registration_data'] = [
                    'fname' => $fname,
                    'lname' => $lname,
                    'username' => $username,
                    'email' => $email,
                    'phonenum' => $phonenum,
                    'sex' => $sex,
                    'password' => $password,
                    'image' => $image
                ];

                // Debugging output
                echo '<pre>';
                echo 'Session OTP Set: ';
                print_r($_SESSION['otp_verification_code']);
                echo 'Registration Data Set: ';
                print_r($_SESSION['registration_data']);
                echo '</pre>';
                exit();

                // Redirect to OTP verification page
                header('Location: ' . ROOT . '/verification');
                exit();
            } else {
                $message[] = 'Failed to send verification email. Please try again later.';
                return $this->view("signup", ['message' => $message]);
            }
        }
    }

    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Retrieve registration data from session
            if (isset($_SESSION['registration_data']) && isset($_SESSION['otp_verification_code'])) {
                $registrationData = $_SESSION['registration_data'];
                $otpsend = (string)$_SESSION['otp_verification_code'];

                // Debugging output
                echo '<pre>';
                echo 'Data: ';
                print_r($registrationData);
                echo 'OTP Sent: ';
                print_r($otpsend);
                echo 'OTP Entered: ';
                print_r($otp);
                echo '</pre>';
                exit();

                // Validate OTP
                if ((string)$otp === $otpsend) {
                    // Handle admin or customer registration
                    if (stripos($registrationData['username'], 'admin') !== false) {
                        // Admin registration
                        $this->registerAdmin($registrationData);
                    } else {
                        // Customer registration
                        $this->registerCustomer($registrationData);
                    }

                    // Clear registration data from session
                    unset($_SESSION['registration_data']);
                    unset($_SESSION['otp_verification_code']);

                    // Redirect to login or success page
                    header('Location: ' . ROOT . '/address');
                    exit();
                } else {
                    // Incorrect OTP
                    $message = ['Invalid OTP. Please try again.'];
                    return $this->view("verification", ['message' => $message]);
                }
            } else {
                // Registration data not found in session
                $message = ['Registration data not found. Please sign up again.'];
                return $this->view("signup", ['message' => $message]);
            }
        } else {
            // GET request to OTP verification page
            return $this->view("verification");
        }
    }

    private function sendVerificationEmail($toEmail, $otpVerificationCode) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'fishball.12h@gmail.com'; // Your Gmail username
            $mail->Password = 'gsxs barx gapl alpi'; // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('fishball.12h@gmail.com', "Be'astylish Email Verification");
            $mail->addAddress($toEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verify your email address';
            $mail->Body = "Your OTP verification code is: $otpVerificationCode";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    private function registerAdmin($data) {
        $adminModel = new Admin();
        $salt = bin2hex(random_bytes(16));
        $saltedPassword = $salt . $data['password'];
        $hashedPassword = password_hash($saltedPassword, PASSWORD_DEFAULT);

        $adminData = [
            'admin_fname' => $data['fname'],
            'admin_lname' => $data['lname'],
            'admin_username' => $data['username'],
            'admin_email' => $data['email'],
            'admin_passwordsalt'  => $salt,
            'admin_passwordhash' => $hashedPassword,
            'admin_profile' => '/assets/uploaded_img/' . $data['image']['name'],
            'admin_sex' => $data['sex'],
            'admin_phonenum' => $data['phonenum']
        ];

        if ($adminModel->insert($adminData)) {
            // Upload image
            $uploadDir = __DIR__ . '/../../public/assets/uploaded_img/';
            $imagePath = $uploadDir . $data['image']['name'];
            move_uploaded_file($data['image']['tmp_name'], $imagePath);
            return true;
        } else {
            return false;
        }
    }

    private function registerCustomer($data) {
        $customerModel = new Customer();
        $salt = bin2hex(random_bytes(16));
        $saltedPassword = $salt . $data['password'];
        $hashedPassword = password_hash($saltedPassword, PASSWORD_DEFAULT);

        




        $customerData = [
            'CUS_FNAME' => $data['fname'],
            'CUS_LNAME' => $data['lname'],
            'CUS_USERNAME' => $data['username'],
            'CUS_EMAIL' => $data['email'],
            'CUS_PASSWORDHASH' => $hashedPassword,
            'CUS_PASSWORDSALT' => $salt,
            'CUS_PROFILE' => '/assets/uploaded_img/' . $data['image']['name'],
            'CUS_PHONENUM' => $data['phonenum'],
            'CUS_SEX' => $data['sex']
        ];

        $cus_id = $customerModel->insertCustomer($customerData);

        if ($cus_id) {
            // Upload image
            $uploadDir = __DIR__ . '/../../public/assets/uploaded_img/';
            $imagePath = $uploadDir . $data['image']['name'];
            move_uploaded_file($data['image']['tmp_name'], $imagePath);
            return true;
        } else {
            return false;
        }
    }
}
?>

