<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/logoutadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <title>Admin Page</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="img/admin.png" alt="dp">
                </span>
                <div class="text header-text">
                    <span></span>
                    <span class="admin">ADMIN</span>
                </div>
            </div>
            <i class='fas fa-angle-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="<?= ROOT ?>home">
                            <i class="fa fa-dashboard icon"></i>
                            <span class="text nav-text">DASHBOARD</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" id="prod-btn" class="products">
                            <i class="fa fa-dashboard icon"></i>
                            PRODUCTS
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul id="prod-show">
                            <li><a href="<?= ROOT ?>Products" >Product List</a></li>
                            <li><a href="<?= ROOT ?>Category">Category</a></li>
                        </ul>
                    </li>
                    <li class="nav-link">
                        <a href="#" id="order-btn" class="order">
                            <i class='fas fa-clipboard-list icon'></i>
                            ORDERS
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul id="order-show" class="suborder-list">
                            <li><a href="<?= ROOT ?>Orders">Order List</a></li>
                            <li><a href="<?= ROOT ?>OrderPending">Order Pending</a></li>
                            <li><a href="<?= ROOT ?>OrderOnDelivery">Order on Delivery</a></li>
                            <li><a href="<?= ROOT ?>OrderCompleted">Order Completed</a></li>
                            <li><a href="<?= ROOT ?>OrderCancel">Order Cancelled</a></li>
                        </ul>
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
                <li>
                    <a href="<?=ROOT?>/adminAccount">
                        <i class='fas fa-user icon'></i>
                        <span class="text nav-text">ACCOUNT</span>
                    </a>
                </li>
                <li class="logout">
                    <a href="#" id="logout-link">
                        <i class='fas fa-sign-out icon'></i>
                        <span class="text nav-text">LOG OUT</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>


  <!-- logout modal -->
  <div id="logoutModal" class="modal" style="display: none;">
        <div class="modal-content">
            <form action="<?= ROOT ?>/AdminAccount/logoutAdmin" method="post">
                <div class="cancel-container">
                    <div class="cancel">
                        <h3>LOG OUT</h3>
                        <h4>Are you sure you want to logout?</h4>
                    </div>
                    <div class="btns">
                        <input type="button" class="back" value="CANCEL" onclick="closeModal()">
                        <input type="submit" class="logoutbtn" value="YES, LOG OUT">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= ROOT ?>/assets/js/admin.js"></script>
    <script>
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logoutModal').style.display = 'block';
        });

        function closeModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
    </script>
