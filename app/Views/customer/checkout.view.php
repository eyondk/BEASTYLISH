<link rel="stylesheet" href="css/checkout.css">
<?php include 'header.inc.php';?>
<section class="checkoutform">
    <div class="tt">
        <h1>CHECKOUT</h1>
    </div>

    <div class="addressform">
        <form action="" method="get">
            <h3>Address</h3>
            <div class="form-row">
                <input type="text" name="street" id="street" placeholder="Street">
                <input type="text" name="brgy" id="brgy" placeholder="Barangay">
                <input type="text" name="city" id="city" placeholder="City">
                <input type="text" name="province" id="province" placeholder="Province">
                <input type="text" name="zipcode" id="zipcode" placeholder="Zipcode">
            </div>
            <div class="form-checkbox">
                <input type="checkbox" name="address_type" id="address_type">
                <label for="address_type">Set as my default address</label>
            </div>

            <h3 class="payment">Select Payment Method</h3>
            <div class="form-row">
                <button type="button" name="meetup" id="meetup">MEET UP<img src="img/meetup icon.png" alt="meetup icon" width="50" height="50"></button>
                <button type="button" name="cod" id="cod">COD<img src="img/cod icon.png" alt="cod icon" width="50" height="50"></button>
                <button type="button" name="gcash" id="gcash">GCASH<img src="https://i.pinimg.com/originals/ba/f8/81/baf881cb4af4d4b1ec7c8176fe18142c.png" alt="gcash icon" width="50" height="50"></button>
                <button type="button" name="ub" id="ub">UNION BANK<img src="https://i.pinimg.com/564x/7f/18/5b/7f185b1028022ffbd360b0f8b9667104.jpg" alt="union bank icon" width="50" height="50"></button>
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


<script src="js/checkout.js"></script>n