    <?php

    class Account extends Controller{

        public function index(){
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email']) || !isset($_SESSION['user_type'])) {
                // User is not logged in, redirect to the login page
                header('Location: ' . ROOT . '/login');
                exit();
            }
            $cusId = $_SESSION['user_id'];
            $customerModel = new CustomerOrders();

            $orders = $customerModel->getOrders($cusId);
            $this->view("customer/account", ['orders' => $orders]);
        }

        public function updateAccount() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Perform validation here
                $errors = $this->validateUpdate($_POST);
                if (empty($errors)) {
                    // No validation errors, proceed to update
                    $customerModel = new Customer();
                    $updateData = [
                        'CUS_FNAME' => empty($_POST['updatefname']) ? $_SESSION['user_fname'] : $_POST['updatefname'],
                        'CUS_LNAME' => empty($_POST['updatelname']) ? $_SESSION['user_lname'] : $_POST['updatelname'],
                        'CUS_USERNAME' => empty($_POST['updateusername']) ? $_SESSION['user_username'] : $_POST['updateusername'],
                        'CUS_EMAIL' => empty($_POST['email']) ? $_SESSION['user_email'] : $_POST['email'],
                        'CUS_PHONENUM' => empty($_POST['updatephonenum']) ? $_SESSION['user_phonenumber'] : $_POST['updatephonenum'],
                        'CUS_SEX' => empty($_POST['updatesex']) ? $_SESSION['user_sex'] : $_POST['updatesex']
                    ];
                
                    // Handling profile picture upload
                    if (!empty($_FILES['updateprofile']['name'])) {
                        $profilePicturePath = $this->uploadProfilePicture($_FILES['updateprofile']);
                        if ($profilePicturePath) {
                            $updateData['CUS_PROFILE'] = $profilePicturePath;
                        } else {
                            $errors[] = "Failed to upload profile picture.";
                        }
                    }
                
                    if (empty($errors)) {
                        $userId = $_SESSION['user_id'];
                        if ($customerModel->updateCustomerInfo($userId, $updateData)) {
                            // Update session data if necessary
                            $_SESSION['user_fname'] = $updateData['CUS_FNAME'];
                            $_SESSION['user_lname'] = $updateData['CUS_LNAME'];
                            $_SESSION['user_username'] = $updateData['CUS_USERNAME'];
                            $_SESSION['user_email'] = $updateData['CUS_EMAIL'];
                            $_SESSION['user_phonenumber'] = $updateData['CUS_PHONENUM'];
                            $_SESSION['user_sex'] = $updateData['CUS_SEX'];
                            if (isset($updateData['CUS_PROFILE'])) {
                                $_SESSION['user_profile'] = $updateData['CUS_PROFILE'];
                            }
                
                            // Redirect or show success message
                            header("Location: account.php?update=success");
                            exit;
                        } else {
                            $errors[] = "Failed to update account.";
                        }
                    }
                }
                
                $this->view("customer/account", ['errors' => $errors]);
                
            } else {
                $this->view("customer/account");
            }
        }
        
        
        

        private function validateUpdate($data) {
            $errors = [];
            $customerModel = new Customer();
            
            $userId = $_SESSION['user_id'];
        
            // Check if username is unique
            $existingUser = $customerModel->getByUsername($data['updateusername']);
            if ($existingUser) {
                $errors[] = "Username is already taken.";
            }
        
            // Check if email is unique
            $existingUser = $customerModel->getByEmail($data['email']);
            if ($existingUser) {
                $errors[] = "Email is already in use.";
            }
        
            // Check if phone number is unique
            $existingUser = $customerModel->getByPhone($data['updatephonenum']);
            if ($existingUser) {
                $errors[] = "Phone number is already in use.";
            }
        
            // Check image size if a new image is uploaded
            if (isset($_FILES['updateprofile']) && $_FILES['updateprofile']['size'] > 0) {
                $image_size = $_FILES['updateprofile']['size'];
                if ($image_size > 20000000) { // 20MB limit
                    $errors[] = 'Image is too large (maximum 20MB allowed)';
                }
            }
        
            return $errors;
        }
        
        

        

        private function uploadProfilePicture($file) {
            // Handle the file upload
            $uploadDir = __DIR__ . '/../../public/assets/uploaded_img/';
            $imageTmpName = $file['tmp_name'];
            $imageName = basename($file['name']);
            $imagePath = $uploadDir . $imageName;

            // Create the directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    error_log('Error: Failed to create directory for image upload');
                    return null;
                }
            }

            // Move uploaded image to specified folder
            if (!move_uploaded_file($imageTmpName, $imagePath)) {
                error_log('Error: Failed to upload image');
                return null;
            }

            return '/assets/uploaded_img/' . $imageName;
        }



        public function updatePassword() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $errors = $this->validatePasswordUpdate($_POST);
        
                if (empty($errors)) {
                    $customerModel = new Customer();
                    $useremail = $_SESSION['user_email'];
                    $userId = $_SESSION['user_id'];
        
                    // Fetch the current user data
                    $currentUser = $customerModel->getByEmail($useremail);
        
                    // Generate a new salt and hash for the new password
                    
                    $salt = $currentUser->cus_passwordsalt;
                    $saltedPassword = $salt . $_POST['updatepass'];
                    $newPasswordHash = password_hash($saltedPassword, PASSWORD_DEFAULT);
        
                        
                    // Prepare update data
                    $updateData = [
                        'CUS_PASSWORDHASH' => $newPasswordHash,
                    ];
        
                    if ($customerModel->updateCustomerInfo($userId, $updateData)) {
                        // Update session data if necessary
                        $_SESSION['user_passwordhash'] = $newPasswordHash;
        
                        header("Location: account?update=success");
                        exit;
                    } else {
                        $errors[] = "Failed to update account.";
                    }
                }
        
                $this->view("customer/account", ['errors' => $errors]);
            } else {
                $this->view("customer/account");
            }
        }
        
        
        
        
        private function validatePasswordUpdate($data) {
            $errors = [];
            $customerModel = new Customer();
            $useremail = $_SESSION['user_email'];
            
            // Fetch the current user data
            $currentUser = $customerModel->getByEmail($useremail);


            // Debugging output

            

            // echo '<pre>';
            // print_r($passwordHash);
            // echo '</pre>';

            // echo '<pre>';
            // print_r($saltedPassword);
            // echo '</pre>';

            
            

            // echo '<pre>';
            // print_r($currentUser);
            // echo '</pre>';
            // exit();

            


            // Validate old password
            if (!password_verify($currentUser->cus_passwordsalt . $data['oldpass'], $currentUser->cus_passwordhash)) {
                $errors[] = "Old password is incorrect.";
            }

            
            // Validate new password and confirm password
            if ($data['updatepass'] !== $data['confirmpass']) {
                $errors[] = "New password and confirm password do not match.";
            } 
        
            return $errors;
        } 

        
        public function logout() {
            
            // Unset all of the session variables
            $_SESSION = array();
            
            // Destroy the session
            session_destroy();
            
            // Redirect to the login page or any other desired page
            header("Location:" .ROOT. "/login?logout=success");
            exit();
        }

        public function fetchOrders() {
            try {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $status = $_POST['status'];
                    $customerModel = new CustomerOrders();
                    $cusId = $_SESSION['user_id'];  // Assuming customer ID is stored in session
                    
                    $ordersResponse = [];
                    switch ($status) {
                        case 1:
                            $ordersResponse = $customerModel->getOrderPending($cusId);
                            break;
                        case 2:
                            $ordersResponse = $customerModel->getOrderOnShip($cusId);
                            break;
                        case 3:
                            $ordersResponse = $customerModel->getOrderOnDelivery($cusId);
                            break; 
                        case 4:
                            $ordersResponse = $customerModel->getOrderComplete($cusId);
                            break;
                        case 5:
                            $ordersResponse = $customerModel->getOrderCancelled($cusId);
                            break;
                        case 'cancel':
                            $orderId = $_POST['order_id'];
                            $ordersResponse = $customerModel->cancelOrder($orderId, $cusId);
                            break;
                        default:
                            $ordersResponse = ['success' => false, 'message' => 'Invalid status'];
                            break;
                    }
        
                    // Ensure response is in the correct format
                    if (!isset($ordersResponse['success'])) {
                        $ordersResponse = ['success' => true, 'data' => $ordersResponse];
                    }
                    
                    if ($ordersResponse['success'] === false) {
                        $message = isset($ordersResponse['message']) ? $ordersResponse['message'] : 'Unknown error';
                        throw new Exception($message);
                    }
        
                    $orders = isset($ordersResponse['data']) ? $ordersResponse['data'] : [];
                    
                    // Log the orders to see what is being sent
                    error_log("Orders: " . print_r($orders, true));
        
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'orders' => $orders]);
                    exit();
                } else {
                    http_response_code(405);
                    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
                    exit();
                }
            } catch (Exception $e) {
                error_log("Error: " . $e->getMessage());
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
                exit();
            }
        }
        
        
        

        
        
        
            
    }