<?php
    include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | Beastylish</title>
    <link rel="shortcut icon" href="img/Beastylish-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/account.css">
</head>
<body>
    <?php require("home_header.inc.php")?>

    <section class="account">
        <div class="account-sidebar">
            <div class="profile">
                <img src="img/profile1.jpg" alt="profile picture">
                <p class="name">RIZZA MI LOIUSE OLIVER</p>
            </div>
            
            <ul>
                <a id="account-info-link"><i class="fas fa-user"></i><span>ACCOUNT INFO</span></a>
                <a id="orders-link"><i class="fas fa-shopping-cart"></i><span>ORDERS</span></a>
                <a href="#"><i class="fas fa-info-circle"></i><span>POLICY & FAQ</span></a>
                <a id="change-pass-link"><i class="fas fa-key"></i><span>CHANGE PASS</span></a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>LOG OUT</span></a>
            </ul>
        </div>

       <div class="acc_info">
            <form class="user_details" action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                    <div class="inputBox">
                        <span>PROFILE PICTURE</span>
                        <input type="file" id="dp" name="dp" accept="image/jpg, image/jpeg, image/png" class="box" disabled>
                        <input type="hidden" name="old_img">
                        <span>FULL NAME</span>
                        <input type="text" name="fname" class="box" disabled>
                        <span>USERNAME</span>
                        <input type="text" name="username" class="box" disabled>
                        <span>CONTACT NUMBER</span>
                        <input type="text" name="contact" class="box" disabled>
                        <span>SEX</span>
                        <input type="text" name="sex" class="box" disabled>                    
                    </div>
                    <div class="inputBox">
                        <span>EMAIL </span>
                        <input type="email" name="email" class="box" disabled>
                        <span>ADDRESS</span>
                        <input type="text" name="add"  class="box" disabled>      
                        <span>CITY</span>
                        <input type="text" name="city"  class="box" disabled>
                        <span>COUNTRY</span>
                        <input type="text" name="city" class="box" disabled>
                        <span>ZIP CODE</span>
                        <input type="text" name="zipcode" class="box" disabled>
                    </div>
                </div>
                <div class="flex">
                    <a href="admin_page.php" class="btn">EDIT INFO</a>
                </div>
            </form>
                   
       
       
            <form class="edit_acc" action="" method="POST" enctype="multipart/form-data" style="display: none;">
                <div class="flex">
                    <div class="inputBox">
                        <span>PROFILE PICTURE</span>
                        <input type="file" id="dp" name="dp" accept="image/jpg, image/jpeg, image/png" placeholder="Update profile picture" class="box">
                        <input type="hidden" name="old_img">
                        <span>FULL NAME</span>
                        <input type="text" name="fname" placeholder="Update full name" class="box">
                        <span>USERNAME</span>
                        <input type="text" name="username" placeholder="Update username" class="box">
                        <span>CONTACT NUMBER</span>
                        <input type="text" name="contact" placeholder="Update contact number" class="box">
                        <span>SEX</span>
                        <input type="text" name="sex" placeholder="Update sex" class="box">                    
                    </div>
                    <div class="inputBox">
                        <span>EMAIL </span>
                        <input type="email" name="email" placeholder="Update email" class="box">
                        <span>ADDRESS</span>
                        <input type="text" name="add"  placeholder="Update address" class="box">      
                        <span>CITY</span>
                        <input type="text" name="city"  placeholder="Update city" class="box">
                        <span>COUNTRY</span>
                        <input type="text" name="city" placeholder="Update country" class="box">
                        <span>ZIP CODE</span>
                        <input type="text" name="zipcode" placeholder="Update zip code" class="box">
                    </div>
                </div>
                <div class="flex">
                    <input type="submit" class="btn" value="UPDATE" name="update_profile" >
                    <a class="option-btn">BACK</a>
                </div>
            </form>
       </div>

       <div class="changePass" style="display: none;">
            <form class="changepassForm" action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                        <div class="inputBox">
                            <input type="hidden" name="old_pass">
                            <span>OLD PASSWORD </span>
                            <input type="password" name="update_pass"  placeholder="Enter previous password" class="box">
                            <span>NEW PASSWORD </span>
                            <input type="password" name="new_pass"  placeholder="Enter new password" class="box">
                            <span>CONFIRM NEW PASSWORD </span>
                            <input type="password" name="confirm_pass"  placeholder="Confirm new password" class="box">
                        </div>
                </div>
                <div class="flex">
                    <input type="submit" class="btn" value="UPDATE PASSWORD" name="update_profile" >
                </div>
            </form>
       </div>


       <div class="orders" style="display: none;">
            <div class="order-container">
                <p>MY ORDERS</p>
            </div>

       </div>
    </section>  

    
    <script src="js/account.js"></script>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
</body>
</html>
