<?php
    include 'config.php';

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $password = md5($_POST['password']);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        $cpassword = md5($_POST['cpassword']);
        $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);
    
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;

        $select = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $select->execute([$email]);

        if($select->rowCount() > 0){
            $message[] = 'user email already existed!';
        } else{
            if($password != $cpassword){
                $message[] = 'confirm password not matched!';
            } else{
                $insert = $conn->prepare("INSERT INTO user(NAME, EMAIL, PASSWORD, IMAGE) VALUES(?,?,?,?)");
                $insert->execute([$name, $email, $password, $image]);
                if($insert){
                    if($image_size > 20000000){
                        $message[] = 'Image is too large!';
                    } else{
                        move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'SignedUp successfully!';
                        header('location:login.php');
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/components.css">
</head>
<body>



<section class="form-container">
    <form action="" enctype="multipart/form-data" method="POST">
        <h3>SignUp</h3>
        <h4>create your account</h4>
        <?php 
            if(isset($message)){
                foreach($message as $message){
                echo' 
                <div class="message">
                        <span> '.$message.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
                }
            }
        ?>
        <input type="text" name="name" class="box" placeholder="FULL NAME" required>
        <input type="email" name="email" class="box" placeholder="EMAIL" required>
        <input type="password" name="password" class="box" placeholder="PASSWORD" required>
        <input type="password" name="cpassword" class="box" placeholder="CONFIRM PASSWORD" required>
        <input type="file" name="image" id="files" class="box" style="display: flex;" required accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="Signup" class="btn" name="submit">
        <p>already have account? <a href="login.php">login now</a></p>
    </form>

</section>
</body>
</html>