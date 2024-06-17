


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/orders.css">
    <title>Document</title>
</head>
<body>
    <?php include 'admin_header.php';?>
    <section class="home">
    <div class="text">ORDERS</div>
    <hr id = "line" />
    <div class="container">
        
        <div class="product-display">
            <div class="searchbar">
                <form action="" method="get">
                    <button type="submit" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" name="" id="" class="searchInput" placeholder="Search for Orders">
                </form>
            </div>
            <div class="table-container">
                <table class="product-display-table">
                    <thead>
                        <tr>
                            <th>ORDER ID</th>
                            <th>ORDER DATE</th>
                            <th>CUSTOMER NAME</th>
                            <th>TOTAL COST</th>
                            <th>PAYMENT METHOD</th>
                            <th>PAYMENT STATUS</th>
                            <th>STATUS</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach($orders as $order ): ?>
                                    <tr>
                                        <td><?= $order['order_id'] ?></td>
                                        <td><?= $order['order_date'] ?></td>
                                        <td><?= $order['customer_name'] ?></td>
                                        <td>&#8369; <?= $order['order_total'] ?></td>
                                        <td><?= $order['payment_method'] ?></td>
                                        <td><?= $order['payment_status'] ?></td>
                                        <td>
                                        <select name="order_status" class="order-status box" 
                                            data-order-id="<?= $order['order_id'] ?>" 
                                            data-original-status="<?= $order['order_status'] ?>" 
                                            data-payment-method="<?= $order['payment_method'] ?>" 
                                            data-payment-status="<?= $order['payment_status'] ?>">
                                        <option value="On Ship" <?= $order['order_status'] == 'On Ship' ? 'selected' : '' ?>>On Ship</option>
                                        <option value="On Delivery" <?= $order['order_status'] == 'On Delivery' ? 'selected' : '' ?>>On Delivery</option>
                                        
                                        </select>
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="totalproduct">
            <?php $orderCount = count($orders);?>
                <p class="tottext">Total Orders on Delivery: <?= $orderCount ?></p>
            </div>
        </div>
    </div>  
</section>
                     
<!-- View product Modal -->
<div id="viewProdModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <h2>ORDER DETAILS</h2>
        <div class="order-info">
            <p><strong>Order ID:</strong> <span id="orderID">1111</span></p>
            <p><strong>Name:</strong> <span id="customerName">Sample NameAdd</span></p>
            <p><strong>Phone Number:</strong> <span id="phoneNumber">0928298203</span></p>
            <p><strong>Email:</strong> <span id="email">name@gmail.com</span></p>
            <p><strong>Address:</strong> <span id="address">sitio Pangpang Nalumos City</span></p>
        </div>
        <div class="products-info">
            <h3>Products Ordered</h3>
            <div id="productsContainer">
             
               

               
            </div>
            <p><strong>Total Items Ordered:</strong> <span id="totalItems">74</span></p>
            <p><strong>Status:</strong> <span id="orderStatus">Pending</span></p>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?=ASSETS?>js/orderondeliver.js"></script>
<script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
