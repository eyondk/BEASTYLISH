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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/admin.css">
</head>
<body>
    
    <nav class="sidebar close">
        <header>
            <div class="img-text">
                <span class="image">
                    <img src="img/IMG_20221210_141334.jpg" alt="dp">
                </span>

                <div class="text header-text">
                    <span class="name">ADMIN NAME</span>
                    <span class="admin">ADMIN</span>
                </div>
            </div>

            <i class='fas fa-angle-right toggle' ></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu links">
                    <li class="nav-link">
                        <a href= "<?=ROOT?>Dashboard" >
                        <i class="fa fa-dashboard icon"></i>
                        <span class="text nav-text">DASHBOARD</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?=ROOT?>Products">
                        <i class='fas fa-shopping-cart icon'></i>
                        <span class="text nav-text">PRODUCTS</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="<?=ROOT?>Orders">
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

            <div class="botton-content">
                    <li class="">
                        <a href="logout.php">
                        <i class='fas fa-sign-out icon'></i>                        
                        <span class="text nav-text">LOG OUT</span>
                        </a>
                    </li>
            </div>
        </div>
    </nav> 
    
</body>
    
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="<?=ASSETS?>js/chart1.js"></script>
<script src="<?=ASSETS?>js/chart2.js"></script>
<script src="<?=ASSETS?>js/admin.js"></script>
</html>