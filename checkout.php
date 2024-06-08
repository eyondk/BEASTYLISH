<link rel="stylesheet" href="css/checkout.css">
<?php require('user_header.inc.php')?>

<section class="checkoutform">
    <div class="tt">
        <h1>CHECKOUT</h1>
    </div>

    <div class="addressform">
        <form action="" method="get">
            <h3>Shipping Address</h3>
            <div class="form-row">
                <input type="text" name="street" id="street" placeholder="Street">
                <input type="text" name="brgy" id="brgy" placeholder="Barangay">
                <input type="text" name="city" id="city" placeholder="City">
                <input type="text" name="province" id="province" placeholder="Province">
                <input type="text" name="zipcode" id="zipcode" placeholder="Zipcode">
            </div>
            <div class="form-checkbox">
                <input type="checkbox" name="address_type" id="address_type">
                <label for="address_type">My shipping information is the same as my billing information.</label>
            </div>
            
            <h3 class="billadd">Billing Address</h3>
            <div class="form-row">
                <input type="text" name="street" id="street" placeholder="Street">
                <input type="text" name="brgy" id="brgy" placeholder="Barangay">
                <input type="text" name="city" id="city" placeholder="City">
                <input type="text" name="province" id="province" placeholder="Province">
                <input type="text" name="zipcode" id="zipcode" placeholder="Zipcode">
            </div>

            <h3 class="payment">Select Payment Method</h3>
            <div class="form-row">
                <button type="button" name="meetup" id="meetup">MEET UP<img src="img/meetup icon.png" alt="meetup icon" width="50" height="50"></button>
                <button type="button" name="cod" id="cod">COD<img src="img/cod icon.png" alt="cod icon" width="50" height="50"></button>
                <button type="button" name="gcash" id="gcash">GCASH<img src="https://i.pinimg.com/originals/ba/f8/81/baf881cb4af4d4b1ec7c8176fe18142c.png" alt="gcash icon" width="50" height="50"></button>
                <button type="button" name="ub" id="ub">UNION BANK<img src="https://i.pinimg.com/564x/7f/18/5b/7f185b1028022ffbd360b0f8b9667104.jpg" alt="union bank icon" width="50" height="50"></button>
            </div>
        </form>
    </div>

    <div class="form-buttons">
        <button type="button" class="cancel-btn" id="cancel">Cancel Checkout</button>
        <button type="button" class="continue-btn" onclick="confirmOrder()">Confirm Order</button>
        </div>
</section>


 <!-- Order Confirmation Modal -->
<div id="orderConfirmationModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Order Summary</h2>
        <div id="orderDetails">
            <!-- Order details will be populated here -->
        </div>
        <button type="button" class="pay-now-btn" onclick="payNow()">Pay Now</button>
    </div>
</div>


<script src="js/checkout.js"></script>