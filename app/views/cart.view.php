<?php require('shared/header.inc.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/cart.css">
    <style>
        .qty-container {
            display: flex;
            align-items: center;
        }
        .qty-container .wrapper {
            display: flex;
            align-items: center;
        }
        .qty-container button {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            margin: 0 5px;
        }
        .qty-container .num {
            width: 50px;
            text-align: center;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="tt">
    <h1>SHOPPING CART</h1>
</div>
<main class="mainCart">
    <div class="cart">
        <div class="product-display">
            <div class="table-container">
                <table class="product-display-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($cart_items)): ?>
                        <?php foreach ($cart_items as $item): ?>
                          <?php
                            // Calculate the discounted price if discount_percent is available
                            $final_price = !empty($item['discount_percent']) ? $item['prod_price'] * (1 - $item['discount_percent'] / 100) : $item['prod_price'];
                            $subtotal = $final_price * $item['cart_qty'];
                            ?>
                       
                        <tr data-cart-id="<?= htmlspecialchars($item['cart_id']); ?>" data-prod-price="<?= htmlspecialchars($final_price); ?>">
                            
                            <td>
                                <form onsubmit="removeItem(event, this)">
                                    <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']); ?>" />
                                    <button type="submit" class="delete">&times;</button>
                                </form>
                            </td>
                            <td>
                                <img src="<?= htmlspecialchars($item['image_path']); ?>" alt="product" width="100" height="100">
                            </td>
                            <td><?= htmlspecialchars($item['prod_name']); ?></td>
                            <td>&#8369; <?= htmlspecialchars($final_price); ?></td>
                            <td>
                                <div class="qty-container">
                                    <div class="wrapper">
                                        <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']); ?>" />
                                        <button type="button" class="minus" onclick="updateQuantity(this, -1)">-</button>
                                        <input type="number" min="1" name="cart_qty" class="num" value="<?= htmlspecialchars($item['cart_qty']); ?>" onchange="updateQuantity(this, 0)">
                                        <button type="button" class="plus" onclick="updateQuantity(this, 1)">+</button>
                                    </div>
                                </div>
                            </td>
                            <td class="subtotal">&#8369; <?= htmlspecialchars(number_format($item['prod_price'] * $item['cart_qty'], 2)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($cart_items)): ?>
            <div>
             <div>
<!-- Inside cart.view.php -->
<button type="button" class="deleteall" id="delete-all">DELETE ALL ITEMS</button>
</div>



            </div>
            <?php endif; ?>
        </div>
        <div class="cartTotals">
            <div class="carttot">
                <p class="cart-tit">Cart totals</p>
                <div class="subtot">
                    <p>Subtotal (<span id="item-count"><?= count($cart_items); ?></span> Items)</p>
                    <p>&#8369; <span id="subtotal"><?= htmlspecialchars(number_format($subtotal, 2)); ?></span></p>

                </div>
                <div class="shipping">
                    <p>Delivery Fee</p>
                    <p>&#8369; <span id="delivery-fee"><?= htmlspecialchars(number_format($deliveryFee, 2)); ?></span></p>
                </div>
                
                <div class="total">
                    <p>Total</p>
                    <p>&#8369; <span id="total"><?= htmlspecialchars(number_format($total, 2)); ?></span></p>

                </div>
                <button id="proceedtocheckout" class="add-btn">Proceed To Checkout</button>
            </div>
        </div>
    </div>
</main>
<script src="<?=ROOT?>/assets/js/addtocart.js"></script>

</body>
</html>
