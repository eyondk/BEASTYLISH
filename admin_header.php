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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Admin Page</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <?php
                    $select_profile = $conn->prepare("SELECT * FROM user WHERE USER_ID = ?");
                    $select_profile->execute([$admin_id]);
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

                ?>
                <span class="image">
                    <img src="uploaded_img/<?= $fetch_profile['IMAGE']?>" alt="dp">
                </span>

                <div class="text header-text">
                    <span class="name"><?= $fetch_profile['NAME']?></span>
                    <span class="admin">ADMIN</span>
                </div>
            </div>

            <i class='fas fa-angle-right toggle' ></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                        <i class="fa fa-dashboard icon"></i>
                        <span class="text nav-text">DASHBOARD</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='fas fa-shopping-cart icon'></i>
                        <span class="text nav-text">PRODUCTS</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='fas fa-clipboard-list icon'></i>
                        <span class="text nav-text">ORDERS</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='fas fa-user-friends icon'></i>
                        <span class="text nav-text">CUSTOMER</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#">
                    <i class='fas fa-user icon'></i>
                    <span class="text nav-text">ACCOUNT</span>
                    </a>
                </li>

                <li class="logout">
                    <a href="logout.php">
                    <i class='fas fa-sign-out icon'></i>                        
                    <span class="text nav-text">LOG OUT</span>
                    </a>
                </li>
                
            </div>
        </div>

    </nav>

    <section class="home">
        <div class="text">Dashboard Sidebar</div>
    </section>

    <script src="js/admin.js"></script>

</body>
</html>
