<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- CSS -->
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/latestprod.css" />

    <style>
        .sale-details { 
            position: absolute; 
            height: 50px; 
            width: 50px; 
            top: 10px; 
            font-size: 17px; 
            left: 10px; 
            background-color: #cc852f; 
            color: white; 
            padding: 5px; 
            border-radius: 50%; 
        } 
        .sale-circle { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
        } 
        .modal-sale { 
            padding-top: 10px;
            color: white;
        } 
        .prod_name-price .price del { 
            color: #6c4a21;
            margin-right: 5px; 
            margin-left: 5px;
            margin-top: 1px;
            opacity: 80%;
            font-size: 13px;
        }
    </style>
</head>
<body>
<div class="container swiper">
    <a href="<?= ROOT ?>/shop" class="view-all">View all products &#10230;</a>
    <div class="slide-container">
        <div class="card-wrapper swiper-wrapper">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="card swiper-slide">
                        <div class="image-box">
                            <img src="<?= $product['image_path'] ?>" alt="<?= $product['prod_name'] ?>" />
                            <?php if ($product['discount_percent'] > 0): ?>
                                <div class="sale-details">
                                    <div class="sale-circle">
                                        <span class="modal-sale"><?= intval($product['discount_percent']) ?>%</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-details">
                            <div class="prod_name-price">
                                <h3 class="prod_name"><?= $product['prod_name'] ?></h3>
                                <?php if ($product['discount_percent'] > 0): ?>
                                    <?php
                                        $discountedPrice = $product['prod_price'] - ($product['prod_price'] * $product['discount_percent'] / 100);
                                    ?>
                                    <h4 class="price">&#8369;<?= number_format($discountedPrice, 2) ?><del>&#8369;<?= number_format($product['prod_price'], 2) ?></del></h4>
                                <?php else: ?>
                                    <h4 class="price">&#8369;<?= number_format($product['prod_price'], 2) ?></h4>
                                <?php endif; ?>
                            </div>
                            <div class="button-box">
                            <button class="product-button" data-product-id="<?= $product['prod_id'] ?>">ADD TO CART</button>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="swiper-button-next swiper-navBtn"></div>
    <div class="swiper-button-prev swiper-navBtn"></div>
    <div class="swiper-pagination"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?=ROOT?>/assets/js/latestprod.js"></script>
<script src="<?=ROOT?>/assets/js/addtocart.js"></script> <!-- Include the new JavaScript file -->
</body>
</html>
