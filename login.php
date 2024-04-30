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
        

        if($select->rowCount() > 0){
            if($row['USER_TYPE'] == 'admin'){
                
                $_SESSION['admin_id']= $row['USER_ID'];
                header('location:admin_page.php');
            } elseif($row['USER_TYPE'] == 'user'){
            
                $_SESSION['user_id']= $row['USER_ID'];
                header('location:home.php');
            } else{
                $message[] = 'no user found.';
            }
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
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/components.css">
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
        <input type="submit" value="Login" class="btn" name="submit">
        <p>don't have an account? <a href="signup.php">signUp now</a></p>
    </form>

</section>
</body>
</html>