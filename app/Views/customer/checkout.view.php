<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/checkout.css">
    <title>Checkout</title>
</head>
<body>
<?php include 'header.inc.php'; ?>

<section class="checkoutform">
    <div class="tt">
        <h1>CHECKOUT</h1>
    </div>

    <div class="addressform">
        <form action="" method="get">
            <h3>Address</h3>
            <div class="form-row">
                        <input type="text" name="street" value="<?= isset($_SESSION['user_street']) ? htmlspecialchars($_SESSION['user_street']) : '' ?>" >
                        <select class="box" name="updatecity" id="city">
                            <option value="" disabled selected>City</option>
                            <option value="BOGO CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'BOGO CITY') ? 'selected' : '' ?>>Bogo City</option>
                            <option value="CAR CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'CAR CITY') ? 'selected' : '' ?>>Carcar City</option>
                            <option value="CEBU CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'CEBU CITY') ? 'selected' : '' ?>>Cebu City</option>
                            <option value="DANAO CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'DANAO CITY') ? 'selected' : '' ?>>Danao City</option>
                            <option value="LAPU-LAPU CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'LAPU-LAPU CITY') ? 'selected' : '' ?>>Lapu-lapu City</option>
                            <option value="MANDAUE CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'MANDAUE CITY') ? 'selected' : '' ?>>Mandaue City</option>
                            <option value="NAGA CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'NAGA CITY') ? 'selected' : '' ?>>Naga City</option>
                            <option value="TALISAY CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'TALISAY CITY') ? 'selected' : '' ?>>Talisay City</option>
                            <option value="TOLEDO CITY" <?= (isset($_SESSION['user_city']) && $_SESSION['user_city'] === 'TOLEDO CITY') ? 'selected' : '' ?>>Toledo City</option>
                        </select>
                        <input type="text" name="province"  value="<?= isset($_SESSION['user_province']) ? htmlspecialchars($_SESSION['user_province']) : '' ?>" disabled>
                        <input type="text" name="mess" value="<?= isset($_SESSION['user_infoaddress']) ? htmlspecialchars($_SESSION['user_infoaddress']) : '' ?>" >

            </div>

        <h3 class="payment">Select Payment Method</h3>
        <div class="form-row">
            <div class="wrapper">
                <input type="radio" name="select" id="option-1" value="MEET UP">
                <input type="radio" name="select" id="option-2" value="COD">
                <input type="radio" name="select" id="option-3" value="GCASH">
                <input type="radio" name="select" id="option-4" value="PAYPAL">

                <label for="option-1" class="option option-1">
                    <div class="dot"></div>
                    <span>MEET UP</span>
                </label>
                <label for="option-2" class="option option-2">
                    <div class="dot"></div>
                    <span>COD via Maxim</span>
                </label>
                <label for="option-4" class="option option-4">
                    <div class="dot"></div>
                    <span>PayPal</span>
                </label>
            </div>
        </div>

        <h3 class="order">Order Summary</h3>
        <?php if (isset($data) && !empty($data)): ?>
        <h5>Subtotal (<?= count($data['cart_items']) ?> Items): &#x20B1; <span id="subtotal"><?= number_format($data['subtotal'], 2) ?></span></h5>
        <h5>Delivery Fee: &#x20B1; <span id="delivery_fee"><?= number_format($data['delivery_fee'], 2) ?></span></h5>
        <h5>Total: &#x20B1; <span id="total"><?= number_format($data['total'], 2) ?></span></h5>
        <div class="cart-items">
            <?php foreach ($data['cart_items'] as $item): ?>
                <div class="cart-item" data-product-id="<?= htmlspecialchars($item['prod_id']) ?>" data-cart-id="<?= htmlspecialchars($item['cart_id']) ?>">
                    <img src="<?= ASSETS ?>/images/<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['prod_name']) ?>" width="50" height="50">
                    <p><?= htmlspecialchars($item['prod_name']) ?> - &#x20B1; <?= number_format($item['prod_price'], 2) ?> x <span class="quantity"><?= htmlspecialchars($item['cart_qty']) ?></span> = &#x20B1; <?= number_format($item['subtotal'], 2) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p>No items in the cart.</p>
        <?php endif; ?>
    </div>

    <input type="hidden" id="customerId" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
    <div class="form-buttons">
        <button type="button" class="cancel-btn" id="cancel">Cancel Checkout</button>
        <button type="button" class="continue-btn" id="checkoutbtn">Confirm Order</button>
    </div>
</section>

<!-- Order Confirmation Modal -->
<div id="checkedModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeCheckedModal">&times;</span>
        <h2>Order processed successfully!</h2>
        <button type="button" class="home-btn" id="goHome">Go back to home</button>
    </div>
</div>

<!-- PayPal Modal -->
<div id="paypalModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closePaypalModal">&times;</span>
        <div id="paypal-button-container"></div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AS05SuIBsjiBTF98H9ldRLJkzBQ28aJ8O9p7AIs_spSXvqe5SvQiADBmffe2BbtBk7QX2UuKjCXNzd7A&currency=USD"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?= ASSETS ?>/js/checkout.js"></script>

</body>
</html>
