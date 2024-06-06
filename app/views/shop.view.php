<?php require("shared/header.inc.php")?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Beastylish</title>
    <link rel="shortcut icon" href="<?=ROOT?>/assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/shop.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/latestprod.css">
</head>
<body>

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
                <input type="search" name="search" id="searchInput" class="searchInput" placeholder="Search for Products">
            </form>
        </div>

        <div class="product-gallery">
            <?php if (isset($is_search) && $is_search): ?>
                <?php if (!empty($search_results)): ?>
                    <?php foreach ($search_results as $product): ?>
                        <div class="product-card">
                            <div class="sale-details">
                                <p class="sale">5&#37;</p>
                            </div>
                            <div class="main-images">
                                <img class="product-img" src="<?= $product['prod_image'] ?>" alt="<?= $product['prod_name'] ?>">
                            </div>
                            <div class="details">
                                <span class="product-name"><?= $product['prod_name'] ?></span>
                            </div>
                            <div class="size-price">
                                <div class="price">
                                    <span class="price-num">&#x20B1;<?= $product['prod_price'] ?></span>
                                    <span class="price-num"><del>&#x20B1;12.00</del></span>
                                </div>
                            </div>
                            <div class="button">
                                <button type="button" class="buy-btn">Buy Now</button>
                                <button type="button" class="add-btn">Add To Cart</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products found for your search.</p>
                <?php endif; ?>
            <?php else: ?>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="sale-details">
                                <p class="sale">5&#37;</p>
                            </div>
                            <div class="main-images">
                                <img class="product-img" src="<?= $product['prod_image'] ?>" alt="<?= $product['prod_name'] ?>">
                            </div>
                            <div class="details">
                                <span class="product-name"><?= $product['prod_name'] ?></span>
                            </div>
                            <div class="size-price">
                                <div class="price">
                                    <span class="price-num">&#x20B1;<?= $product['prod_price'] ?></span>
                                    <span class="price-num"><del>&#x20B1;12.00</del></span>
                                </div>
                            </div>
                            <div class="button">
                                <button type="button" class="buy-btn">Buy Now</button>
                                <button type="button" class="add-btn">Add To Cart</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products available.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <!-- The Modal -->
        
        <div id="myModal" class="modal">
            <!-- Modal content dynamically filled by JavaScript -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="product-card">
                    <div class="sale-details">
                        <p class="sale">5%</p>
                    </div>
                    <div class="main-images">
                        <img class="modal-product-img" src="" alt="Product Image">
                    </div>
                    <div class="details">
                        <span class="modal-product-name"></span>
                    </div>
                    <div class="size-price">
                        <div class="price">
                            <span class="modal-price-num"></span>
                            <span class="origprice-num"><del></del></span>
                        </div>
                    </div>
                    <div class="prod-det">
                        <p class="modal-description"></p>
                        <div class="content size">
                            <form action="" method="post">
                                <div class="size-select">
                                    <p>Size:</p>
                                    <!-- Add radio buttons for sizes here if needed -->
                                </div>
                            </form>
                            <div class="qty-container">
                                <p>Qty:</p>
                                <div class="wrapper">
                                    <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                    <input type="text" name="quantity" id="quantity" class="num" value="1">
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

<script src="<?=ROOT?>/assets/js/shop.js"></script>
<script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
</body>
</html>
