<?php

class SignUp extends Controller {
    public function index() {
        $this->view("signup");
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
            $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phonenum = filter_input(INPUT_POST, 'phonenum', FILTER_SANITIZE_STRING);
            $sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);
            $password = $_POST['password'];
            $cpassword = $_POST['cpassword'];
            
            $image = $_FILES['image'];
            $image_name = $image['name'];
            $image_tmp_name = $image['tmp_name'];
            $image_error = $image['error'];

            $message = [];

            // Validate
            if ($password !== $cpassword) {
                $message[] = 'Passwords do not match';
                error_log('Validation error: Passwords do not match');
                return $this->view("signup", ['message' => $message]);
            }

            if ($image_error !== UPLOAD_ERR_OK) {
                $message[] = 'Please upload a valid image';
                error_log('Validation error: Please upload a valid image');
                return $this->view("signup", ['message' => $message]);
            } else {
                $image_size = $image['size'];
                if ($image_size > 20000000) { // 20MB limit
                    $message[] = 'Image is too large (maximum 20MB allowed)';
                    error_log('Validation error: Image is too large (maximum 20MB allowed)');
                    return $this->view("signup", ['message' => $message]);
                }
            }

            $customerModel = new Customer();
            $adminModel = new Admin();

            // Check if email or phone number is already registered
            if ($customerModel->getByEmail($email) || $adminModel->getByEmail($email)) {
                $message[] = 'Email address is already registered';
                error_log('Validation error: Email address is already registered');
            }

            if ($customerModel->getByPhone($phonenum) || $adminModel->getByPhone($phonenum)) {
                $message[] = 'Phone number is already registered';
                error_log('Validation error: Phone number is already registered');
            }

            if ($adminModel->getByUsername($username) || $customerModel->getByUsername($username)) {
                $message[] = 'Username is already taken';
                error_log('Validation error: Username is already taken');
            }

            if (stripos($username, 'admin') !== false) {


                if (empty($message)) {
                    $upload_dir = __DIR__ . '/../../public/assets/uploaded_img/';
                    $image_path = $upload_dir . $image_name;

                    if (!file_exists($upload_dir)) {
                        if (!mkdir($upload_dir, 0777, true)) {
                            $message[] = 'Failed to create directory for image upload';
                            error_log('Error: Failed to create directory for image upload');
                            return $this->view("signup", ['message' => $message]);
                        }
                    }

                    if (!move_uploaded_file($image_tmp_name, $image_path)) {
                        $message[] = 'Failed to upload image';
                        error_log('Error: Failed to upload image');
                        return $this->view("signup", ['message' => $message]);
                    }

                    $salt = bin2hex(random_bytes(16));
                    $saltedPassword = $salt . $password;
                    $passwordHash = password_hash($saltedPassword, PASSWORD_DEFAULT);


                    $adminData = [
                        'admin_fname' => $fname,
                        'admin_lname' => $lname,
                        'admin_email' => $email,
                        'admin_username' => $username,
                        'admin_passwordhash' => $passwordHash,
                        'admin_passwordsalt' => $salt,
                        'admin_profile' => '/assets/uploaded_img/' . $image_name,
                        'admin_sex' => $sex,
                        'admin_phonenum' => $phonenum
                    ];

                    if ($adminModel->insert($adminData)) {
                        header('Location: ' . ROOT . '/login');
                        exit();
                    } else {
                        $message[] = 'Error occurred while signing up. Please try again later.';
                        error_log('Database error: Error occurred while signing up as admin');
                        return $this->view("signup", ['message' => $message]);
                    }
                }
            } else {

                if (empty($message)) {
                    $upload_dir = __DIR__ . '/../../public/assets/uploaded_img/';
                    $image_path = $upload_dir . $image_name;

                    if (!file_exists($upload_dir)) {
                        if (!mkdir($upload_dir, 0777, true)) {
                            $message[] = 'Failed to create directory for image upload';
                            error_log('Error: Failed to create directory for image upload');
                            return $this->view("signup", ['message' => $message]);
                        }
                    }

                    if (!move_uploaded_file($image_tmp_name, $image_path)) {
                        $message[] = 'Failed to upload image';
                        error_log('Error: Failed to upload image');
                        return $this->view("signup", ['message' => $message]);
                    }

                    $salt = bin2hex(random_bytes(16));
                    $saltedPassword = $salt . $password;
                    $passwordHash = password_hash($saltedPassword, PASSWORD_DEFAULT);

                    $data = [
                        'CUS_FNAME' => $fname,
                        'CUS_LNAME' => $lname,
                        'CUS_USERNAME' => $username,
                        'CUS_EMAIL' => $email,
                        'CUS_PASSWORDHASH' => $passwordHash,
                        'CUS_PASSWORDSALT' => $salt,
                        'CUS_PROFILE' => '/assets/uploaded_img/' . $image_name,
                        'CUS_PHONENUM' => $phonenum,
                        'CUS_SEX' => $sex
                    ];

                    if ($customerModel->insert($data)) {
                        header('Location: ' . ROOT . '/login');
                        exit();
                    } else {
                        $message[] = 'Error occurred while signing up. Please try again later.';
                        error_log('Database error: Error occurred while signing up');
                        return $this->view("signup", ['message' => $message]);
                    }
                }
            }

            return $this->view("signup", ['message' => $message]);
        }
    }
}

?>
