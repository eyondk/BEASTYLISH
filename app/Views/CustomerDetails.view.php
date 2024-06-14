<?php include 'admin_header.php'; ?>

<link rel="stylesheet" href="<?= ASSETS ?>css/customerdetails.css">
<section class="home">
<div class="text">CUSTOMERS</div>
<hr id="line" />
    <div class="semiheader">
        <h2>CUSTOMER ID #<?= $data['customer']['cus_id'] ?></h2>
        <div class="delete-div">
            <input type="button" class="cus-dlt-btn" value="DELETE CUSTOMER">
        </div>        
    </div>

    <div class="customerdetails-container">
        <div class="customerdetails-card">
            <div class="pic-name-id">
                <img src="img/11.png" alt="" srcset="" width="200" height="200">
                <h3 class="full-name"><?= $data['customer']['cus_fname'] . ' ' . $data['customer']['cus_lname'] ?></h3>
                <h4>Customer Id #<?= $data['customer']['cus_id'] ?></h4>
            </div>

            <div class="customerdetails-info">
                <div class="orders-div">
                    <i class="fas fa-shopping-cart"></i>
                    <div class="orderdet">
                        <h4 class="total-order"><?= $data['total_orders'] ?></h4>
                        <h5 class="tit">Orders</h5>
                    </div>
                </div>

                <div class="cus-det">
                    <h3><strong>Username:</strong> <?= $data['customer']['cus_username'] ?></h3>
                    <h3><strong>Email:</strong> <?= $data['customer']['cus_email'] ?></h3>
                    <h3><strong>Phone Number:</strong> <?= $data['customer']['cus_phonenum'] ?></h3>
                    <h3><strong>Address:</strong> <?= $data['customer']['customer_address'] ?></h3>
                </div>
            </div>
        </div>

        <div class="orderdetails-card">
            <div class="order-summary">
                <h4>Order Summary</h4>
                <p>Total Orders: <?= $data['total_orders'] ?></p>
                <p>Total Spent: &#8369;<?= number_format($data['total_spent'], 2) ?></p>
            </div>
        </div>
    </div>

    <div class="semifooter">
        <a href="<?= ROOT ?>Customer" class="back">         
            &#10230; BACK TO CUSTOMERS
        </a>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
<script src="<?= ASSETS ?>js/admin.js"></script>
<script src="<?= ASSETS ?>js/customerdetails.js"></script>
