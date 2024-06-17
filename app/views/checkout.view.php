<link rel="stylesheet" href="<?=ROOT?>/assets/css/checkout.css">
<?php require("shared/header.inc.php")?>

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
            <div class="form-checkbox">
                <input type="checkbox" name="address_type" id="address_type">
                <label for="address_type">Set as my default address</label>
            </div>

            <h3 class="payment">Select Payment Method</h3>
            <div class="form-row">
                <div class="wrapper">
                    <input type="radio" name="select" id="option-1" value="">
                    <input type="radio" name="select" id="option-2" value="">
                    <input type="radio" name="select" id="option-3" value="">
                    <input type="radio" name="select" id="option-4" value="">

                    
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>MEET UP</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>COD via Maxim</span>
                    </label>
                    <label for="option-3" class="option option-3">
                        <div class="dot"></div>
                        <span>GCASH</span>
                    </label>
                    <label for="option-4" class="option option-4">
                        <div class="dot"></div>
                        <span>UNION BANK</span>
                    </label>
                </div>



            </div>

            <h3 class="order">Order Summary</h3>
            <h5>Subtotal (3 Items): &#x20B1; 90.05</h5>
            <h5>Delivery Fee: &#x20B1; 90.00</h5>
            <h5>Discount Fee: &#x20B1; 100</h5>
            <h5>Total: &#x20B1; 80.05</h5>        
        
        </form>
    </div>

    <div class="form-buttons">
        <button type="button" class="cancel-btn" id="cancel">Cancel Checkout</button>
        <button type="button" class="continue-btn" id="checkoutbtn" onclick="confirmOrder()">Confirm Order</button>
        </div>
</section>


 <!-- Order Confirmation Modal -->
<div id="checkedModal" class="modal" >
    <div class="modal-content">
        <h2>Ordered processed successfully!</h2>
    </div>
</div>


<script src="js/checkout.js"></script>