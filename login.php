<?php
    include 'config.php';

    session_start();

    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $password = md5($_POST['password']);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $select = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $select->execute([$email, $password]);
        $row = $select->fetch(PDO::FETCH_ASSOC);
        
        // Debug: Output the $row array to see its contents
        error_log(print_r($row, true));

        if($select->rowCount() > 0){
            if($row['USER_TYPE'] == 'admin'){
                
                // Debug: Output the USER_ID value before setting the session variable
                error_log("USER_ID: " . $row['USER_ID']);
                $admin_id = $row['USER_ID'];
                $_SESSION['admin_id'] = $admin_id;
                header('location:admin_page.php');
            } elseif($row['USER_TYPE'] == 'user'){
            
                $_SESSION['user_id']= $row['USER_ID'];
                header('location:home.php');
            }else{
                $message[] = 'no user found.';
            };
        } else{
            $message[] = 'Incorrect email or password!';
        }  
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="shortcut icon" href="img/Beastylish-favicon.png" type="image/x-icon">
    <title>Beastylish</title>
    <style>
        .option_field {
            margin-top: 1px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-container .forgot_pw {
            color: #6c4a21;
            font-size: 15px;
        }
        .form-container .forgot_pw:hover {
            text-decoration: underline;
        }

        .checkbox {
            margin-left: 0.8rem;
            display: flex;
            column-gap: 5px;
            white-space: nowrap;
        }

        .form-container .checkbox input {
            accent-color: #6c4a21;
            background-color: #f1f1f1;
            border: 2px solid #6c4a21;
        }

      

        .checkbox label {
            font-size: 15px;
            cursor: pointer;
            user-select: none;
            color: #6c4a21;
        }
        </style>
</head>
<body>




<section class="form-container">
    <form action="" enctype="multipart/form-data" method="POST">
        <h3>Login</h3>
        <h4>hello!welcome back.</h4>
        <?php 
            if(isset($message)){
                foreach($message as $message){
                echo' 
                <div class="message">
                        <span>'.$message.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
                }
            }
        ?>
        <input type="email" name="email" class="box" placeholder="EMAIL" required>
        <input type="password" name="password" class="box" placeholder="PASSWORD" required>
        
        <div class="option_field">
              <span class="checkbox">
                <input type="checkbox" id="check" />
                <label for="check">remember me</label>
              </span>
              <a href="#" class="forgot_pw">forgot password?</a>
        </div>

        <input type="submit" value="Login" class="btn" name="submit">
        <p>don't have an account? <a href="signup.php">signUp now</a></p>
    </form>

</section>
</body>
</html>
