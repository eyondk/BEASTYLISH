<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=ROOT?>/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/header.css">    
</head>
<body>
    <nav>
        <ul id="menuList">
            <li><a href="<?=ROOT?>/home" class="link">Home</a></li>
            <li><a href="<?=ROOT?>/shop" class="link">SHOP</a></li>
            <li><a href="<?=ROOT?>/about" class="link">About</a></li>
            <li><a  href="<?=ROOT?>/home" class="logo">BEASTYLISH</a></li>
            <li><a href="<?=ROOT?>/account" class="link">Account</a></li>
            <li><a href="<?=ROOT?>/cart" class="link">Cart</a></li>
            <li><a href="<?=ROOT?>/contact" class="link">Contact</a></li>
        </ul>
        <div class="menu-icon">
            <i class="fa-solid fa-bars" onclick="toggleMenu()"></i>
        </div>
    </nav>

    <script>
        let menuList = document.getElementById("menuList");
        menuList.style.maxHeight = "0px";

        function toggleMenu(){
            if(menuList.style.maxHeight == "0px") {
                menuList.style.maxHeight = "300px";
            } else {
                menuList.style.maxHeight = "0px";
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
</body>
