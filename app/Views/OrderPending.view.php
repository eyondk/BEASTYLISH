


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
                                        <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="On Delivery" <?= $order['order_status'] == 'On Delivery' ? 'selected' : '' ?>>On Delivery</option>Wz`
                                        <option value="Cancelled" <?= $order['order_status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
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
                <p class="tottext">Total Orders Pending: <?= $orderCount ?></p>
            </div>
        </div>
    </div>  
</section>
                     

   
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?=ASSETS?>js/orderpending.js"></script>
<script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
