<?php


class adminAccount extends Controller

{  
    
    public function index()
    {   
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: login'); // Adjust the path as needed for your application
            exit();
        }
        
        $this->view('admin/adminAccount');
        
    }
    
   

    public function updateAdmin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = $this->validateUpdate($_POST);

            if (empty($errors)) {
                $adminModel = new Admin();
                $updateData = [
                    'admin_fname' => empty($_POST['updatefname']) ? $_SESSION['admin_fname'] : $_POST['updatefname'],
                    'admin_lname' => empty($_POST['updatelname']) ? $_SESSION['admin_lname'] : $_POST['updatelname'],
                    'admin_username' => empty($_POST['updateusername']) ? $_SESSION['admin_username'] : $_POST['updateusername'],
                    'admin_email' => empty($_POST['email']) ? $_SESSION['admin_email'] : $_POST['email'],
                    'admin_phonenum' => empty($_POST['updatephonenum']) ? $_SESSION['user_phonenum'] : $_POST['updatephonenum'],
                    'admin_sex' => empty($_POST['updatesex']) ? $_SESSION['admin_sex'] : $_POST['updatesex']
                ];

                if (!empty($_FILES['updateprofile']['name'])) {
                    $profilePicturePath = $this->uploadProfilePicture($_FILES['updateprofile']);
                    if ($profilePicturePath) {
                        $updateData['admin_profile'] = $profilePicturePath;
                    } else {
                        $errors[] = "Failed to upload profile picture.";
                    }
                }


                if (!empty($_POST['oldpass']) && !empty($_POST['updatepass']) && !empty($_POST['confirmpass'])) {
                    $passwordErrors = $this->validatePasswordUpdate($_POST);
                    if (empty($passwordErrors)) {
                        $userId = $_SESSION['admin_id'];
                        $admin = $adminModel->getById($userId);
                        $salt = $admin->admin_passwordsalt;
                        $saltedPassword = $salt . $_POST['updatepass'];
                        $updateData['admin_passwordhash'] = password_hash($saltedPassword, PASSWORD_DEFAULT);
                    } else {
                        $errors = array_merge($errors, $passwordErrors);
                    }
                }

                if (empty($errors)) {
                    $userId = $_SESSION['user_id'];
                    if ($adminModel->update($userId, $updateData, 'admin_id')) {
                        $_SESSION['admin_fname'] = $updateData['admin_fname'];
                        $_SESSION['admin_lname'] = $updateData['admin_lname'];
                        $_SESSION['admin_username'] = $updateData['admin_username'];
                        $_SESSION['admin_email'] = $updateData['admin_email'];
                        $_SESSION['admin_phonenum'] = $updateData['admin_phonenum'];
                        $_SESSION['admin_sex'] = $updateData['admin_sex'];
                        if (isset($updateData['admin_profile'])) {
                            $_SESSION['admin_profile'] = $updateData['admin_profile'];
                        }
                        if (isset($updateData['admin_passwordhash'])) {
                            $_SESSION['admin_passwordhash'] = $updateData['admin_passwordhash'];
                        }

                        header("Location: account.php?update=success");
                        exit;
                    } else {
                        $errors[] = "Failed to update account.";
                    }
                }
            }

            $this->view("adminAccount", ['errors' => $errors]);

        } else {
            $this->view("adminAccount");
        }
    }

    private function validateUpdate($data) {
        $errors = [];
        $adminModel = new Admin();

        $userId = $_SESSION['user_id'];

        if (!empty($data['updateusername'])) {
            $existingUser = $adminModel->getByUsername($data['updateusername']);
            if ($existingUser && $existingUser->admin_id != $userId) {
                $errors[] = "Username is already taken.";
            }
        }

        if (!empty($data['email'])) {
            $existingUser = $adminModel->getByEmail($data['email']);
            if ($existingUser && $existingUser->admin_id != $userId) {
                $errors[] = "Email is already in use.";
            }
        }

        if (!empty($data['updatephonenum'])) {
            $existingUser = $adminModel->getByPhone($data['updatephonenum']);
            if ($existingUser && $existingUser->admin_id != $userId) {
                $errors[] = "Phone number is already in use.";
            }
        }

        if (isset($_FILES['updateprofile']) && $_FILES['updateprofile']['size'] > 0) {
            $image_size = $_FILES['updateprofile']['size'];
            if ($image_size > 20000000) {
                $errors[] = 'Image is too large (maximum 20MB allowed)';
            }
        }

         // Password change validation
        if (!empty($data['oldpass'])) {
            if (empty($data['updatepass']) || empty($data['confirmpass'])) {
                $errors[] = "Enter new password and confirm password to change the password.";
            }
        }

        if (empty($data['oldpass']) && (!empty($data['updatepass']) || !empty($data['confirmpass']))) {
            $errors[] = "Enter old password first to change the password.";
        }

        return $errors;
    }

    private function validatePasswordUpdate($data) {
        $errors = [];
        $adminModel = new Admin();
        $userId = $_SESSION['admin_id'];
        $admin = $adminModel->getById($userId);

        if (!password_verify($admin->admin_passwordsalt . $data['oldpass'], $admin->admin_passwordhash)) {
            $errors[] = "Old password is incorrect.";
        }

        if ($data['updatepass'] !== $data['confirmpass']) {
            $errors[] = "New password and confirm password do not match.";
        }

        return $errors;
    }

    private function uploadProfilePicture($file) {
        $uploadDir = __DIR__ . '/../../public/assets/uploaded_img/';
        $imageTmpName = $file['tmp_name'];
        $imageName = basename($file['name']);
        $imagePath = $uploadDir . $imageName;

        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                error_log('Error: Failed to create directory for image upload');
                return null;
            }
        }

        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            error_log('Error: Failed to upload image');
            return null;
        }

        return '/assets/uploaded_img/' . $imageName;
    }

    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("Location:" . ROOT . "/login?logout=success");
        exit();
    }
    
}



