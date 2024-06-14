<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ASSETS?>css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="shortcut icon" href="img/Beastylish-favicon.png" type="image/x-icon">
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
                        <a href="<?=ROOT?>home">
                            <i class="fa fa-dashboard icon"></i>
                            <span class="text nav-text">DASHBOARD</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" id="acc-btn" class="acc">
                        <i class='fas fa-shopping-cart icon'></i>
                            PRODUCTS
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul id="acc-show">
                            <li><a href="<?=ROOT?>Products" class="first-sub">Product List</a></li>
                            <li><a href="<?=ROOT?>Category">Category</a></li>
                            
                        </ul>
                    </li>
                    <li class="nav-link">
                        <a href="#" id="orders-acc-btn" class="acc">
                            <i class='fas fa-clipboard-list icon'></i>
                            ORDERS
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul id="orders-acc-show">
                            <li><a href="<?=ROOT?>Orders" class="first-sub">Order List</a></li>
                            <li><a href="<?=ROOT?>OrderPending">Order Pending</a></li>
                            <li><a href="<?=ROOT?>OrderOnDelivery">Order on Delivery</a></li>
                            <li><a href="<?=ROOT?>OrderComplete">Order Completed</a></li>
                            <li><a href="<?=ROOT?>OrderCancelled">Order Cancelled</a></li>
                        </ul>
                    </li>
                    <li class="nav-link">
                        <a href="<?=ROOT?>Customer">
                            <i class='fas fa-user-friends icon'></i>
                            <span class="text nav-text">CUSTOMER</span>
                        </a>
                    </li>
                
                <li class="nav-link">
                        <a href="<?=ROOT?>Report">
                            <i class='fas fa-chart-bar icon'></i>
                            <span class="text nav-text">REPORT</span>
                        </a>
                    </li>
                </ul>
            
            </div>
            
            <div class="bottom-content">
                <li>
                    <a href="admin_update_profile.php">
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

    <script src="js/admin.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const accBtn = document.getElementById("acc-btn");
            const accShow = document.getElementById("acc-show");

            if (accBtn) {
                accBtn.addEventListener("click", function(event) {
                    event.preventDefault();
                    accShow.classList.toggle("show");
                    accBtn.querySelector(".fa-chevron-down").classList.toggle("flip");

                    // Adjust the position of subsequent list items
                    const parentLi = accBtn.parentElement;
                    const allLis = Array.from(document.querySelectorAll('.sidebar > .menu-bar > .menu-links > li'));
                    const submenuHeight = accShow.classList.contains('show') ? accShow.scrollHeight : 0;

                    let nextElement = parentLi.nextElementSibling;
                    if (nextElement) {
                        nextElement.style.marginTop = accShow.classList.contains('show') ? `${submenuHeight}px` : '0';
                        nextElement = nextElement.nextElementSibling;
                    }
                });
            }
            
        });

        document.addEventListener("DOMContentLoaded", function() {
    const ordersAccBtn = document.getElementById("orders-acc-btn");
    const ordersAccShow = document.getElementById("orders-acc-show");

    if (ordersAccBtn && ordersAccShow) {
        ordersAccBtn.addEventListener("click", function(event) {
            event.preventDefault();
            ordersAccShow.classList.toggle("show");
            ordersAccBtn.querySelector(".fa-chevron-down").classList.toggle("flip");

            // Adjust the position of subsequent list items
            const parentLi = ordersAccBtn.parentElement;
            const allLis = Array.from(document.querySelectorAll('.sidebar > .menu-bar > .menu-links > li'));
            const submenuHeight = ordersAccShow.classList.contains('show') ? ordersAccShow.scrollHeight : 0;

            let nextElement = parentLi.nextElementSibling;
            if (nextElement) {
                nextElement.style.marginTop = ordersAccShow.classList.contains('show') ? `${submenuHeight}px` : '0';
                nextElement = nextElement.nextElementSibling;
            }
        });
    }
});
    </script>
</body>
</html>