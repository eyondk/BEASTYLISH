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
    <title>Shop | Beastylish</title>
    <link rel="shortcut icon" href="img/Beastylish-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/shop.css">
    <link rel="stylesheet" href="css/latestprod.css">

</head>
<body>
    <?php require("user_header.inc.php")?>


    <div class="flex">
        <div class="shopCat">
            <ul>
                <li ><a href="#" class="shopAll">SHOP ALL</a></li>
                <li ><a href="#" class="shopNew">NEW</a></li>
                <li ><a href="#" class="shopSale">SALE</a></li>
                <li>
                    <a href="#" id="acc-btn" class="acc">ACCESSORIES
                    <span class="fa fa-chevron-down first"></span>
                    </a>
                    <ul id="acc-show">
                    <li><a href="#" class="first-sub">Necklace</a></li>
                    <li><a href="#">Bracelet</a></li>
                    <li><a href="#">Sunglass</a></li>
                    <li><a href="#">Earring</a></li>
                    <li><a href="#">Clip</a></li>
                    <li><a href="#">Anklet</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="brandnew-btn" class="brand">BRAND NEW
                    <span class="fa fa-chevron-down second"></span>
                    </a>
                    <ul id="brandnew-show">
                    <li><a href="#" class="first-sub">Tops</a></li>
                    <li><a href="#">Bottoms</a></li>
                    <li><a href="#">Dress</a></li>
                    <li><a href="#">Swimwear</a></li>

                    </ul>
                </li>
                <li>
                    <a href="#" id="preloved-btn" class="pre">PRE-LOVED
                    <span class="fa fa-chevron-down third"></span>
                    </a>
                    <ul id="preloved-show">
                    <li><a href="#" class="first-sub">Tops</a></li>
                    <li><a href="#">Bottoms</a></li>
                    <li><a href="#">Dress</a></li>
                    <li><a href="#">Swimwear</a></li>
                    </ul>
                </li>
                <li><a href="#" class="hand">HANDMADE BOUQUET</a></li>
            </ul>
        </div>

        <div class="product-display">
            <div class="searchbar">
              <form action="" method="get">
                    <button type="submit" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" name="" id="" class="searchInput" placeholder="Search for Products">
              </form>
            </div>

            <div class="product-gallery">
                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5&#37;</p>
                    </div>
                    <div class="main-images">
                        <img class="product-img" src="img/tshirt.jpg">
                    </div>
                    <div class="details">
                        <span class="product-name">ADDIDAS GAZE</span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                        <span class="price-num">&#x20B1;9.00</span>
                        <span class="price-num"><del>&#x20B1;12.00</del></span>
                        </div>
                    </div>
                    <div class="button">
                        <button type="button" class="buy-btn">Buy Now</button>
                        <button type="button" class="add-btn">Add To Cart</button>
                    </div>
                </div>
                

                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5&#37;</p>
                    </div>
                    <div class="main-images">
                        <img class="product-img" src="img/tshirt.jpg">
                    </div>
                    <div class="details">
                        <span class="product-name">ADDIDAS GAZE</span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                        <span class="price-num">&#x20B1;9.00</span>
                        <span class="price-num"><del>&#x20B1;12.00</del></span>
                        </div>
                    </div>
                    <div class="button">
                        <button type="button" class="buy-btn">Buy Now</button>
                        <button type="button" class="add-btn">Add To Cart</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5&#37;</p>
                    </div>
                    <div class="main-images">
                        <img class="product-img" src="img/tshirt.jpg">
                    </div>
                    <div class="details">
                        <span class="product-name">ADDIDAS GAZE</span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                        <span class="price-num">&#x20B1;9.00</span>
                        <span class="price-num"><del>&#x20B1;12.00</del></span>
                        </div>
                    </div>
                    <div class="button">
                        <button type="button" class="buy-btn">Buy Now</button>
                        <button type="button" class="add-btn">Add To Cart</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5&#37;</p>
                    </div>
                    <div class="main-images">
                        <img class="product-img" src="img/tshirt.jpg">
                    </div>
                    <div class="details">
                        <span class="product-name">ADDIDAS GAZE</span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                        <span class="price-num">&#x20B1;9.00</span>
                        <span class="price-num"><del>&#x20B1;12.00</del></span>
                        </div>
                    </div>
                    <div class="button">
                        <button type="button" class="buy-btn">Buy Now</button>
                        <button type="button" class="add-btn">Add To Cart</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5&#37;</p>
                    </div>
                    <div class="main-images">
                        <img class="product-img" src="img/tshirt.jpg">
                    </div>
                    <div class="details">
                        <span class="product-name">ADDIDAS GAZE</span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                        <span class="price-num">&#x20B1;9.00</span>
                        <span class="price-num"><del>&#x20B1;12.00</del></span>
                        </div>
                    </div>
                    <div class="button">
                        <button type="button" class="buy-btn">Buy Now</button>
                        <button type="button" class="add-btn">Add To Cart</button>
                    </div>
                </div>

                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5&#37;</p>
                    </div>
                    <div class="main-images">
                        <img class="product-img" src="img/tshirt.jpg">
                    </div>
                    <div class="details">
                        <span class="product-name">ADDIDAS GAZE</span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                        <span class="price-num">&#x20B1;9.00</span>
                        <span class="price-num"><del>&#x20B1;12.00</del></span>
                        </div>
                    </div>
                    <div class="button">
                        <button type="button" class="buy-btn">Buy Now</button>
                        <button type="button" class="add-btn">Add To Cart</button>
                    </div>
                </div>
            </div>

            <!-- The Modal -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close"> <i class="fa-solid fa-x"></i></span>
                    <div class="product-card">
                        <div class="sale-details">
                            <p class="sale">5&#37;</p>
                        </div>
                        <div class="main-images">
                            <img class="product-img" src="img/tshirt.jpg">
                        </div>
                        <div class="details">
                            <span class="product-name">ADDIDAS GAZE</span>                            
                            <div class="price" style="margin-top:0.5rem;">
                                <span class="price-num" style="color: #6c4a21;">&#x20B1;9.00</span>
                                <span class="origprice-num" style="color: #6c4a21d4;"><del>&#x20B1;12.00</del></span>
                            </div>
                        </div>
                        <div class="size-price">
                            <p class="prod-det">Lorem ipsum dolor sit lorenm i amet, consectetur adipisicing elit. Eum, ea, ducimus!</p>
                            <div class="content size">
                                <form action="" method="post">
                                    <div class="size-select">
                                        <p>Size:</p>
                                        <label for="xsmall">
                                            <input type="radio" name="size" id="xsmall">
                                            <span>XS</span>
                                        </label>
                                        <label for="small">
                                            <input type="radio" name="size" id="small">
                                            <span>S</span>
                                        </label>
                                        <label for="medium">
                                            <input type="radio" name="size" id="medium">
                                            <span>M</span>
                                        </label>
                                        <label for="large">
                                            <input type="radio" name="size" id="large">
                                            <span>L</span>
                                        </label>
                                        <label for="xlarge">
                                            <input type="radio" name="size" id="xlarge">
                                            <span>XL</span>
                                        </label>
                                    </div>
                                </form>


                                <div class="qty-container">
                                    <p>Qty: </p>
                                    <div class="wrapper">
                                        <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                        <input type="text" name="" id="" class="num" value="01">
                                        <button class="plus">+</button>
                                    </div>

                                </div>

                            </div>
                            
                        </div>
                        <div class="button">
                            <button type="button" class="buy-btn">Buy Now</button>
                            <button type="button" class="add-btn">Add To Cart</button>
                        </div>
                    </div>
                </div>

            </div>
            
            

        </div>
    </div>


    <script src="js/shop.js"></script>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>

</body>
</html>
