<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>css/orders.css">
    <title>Customer Details</title>
</head>
<body>
    <?php include 'admin_header.php'; ?>
    <section class="home">
        <div class="text">CUSTOMERS</div>
        <hr id="line" />
        <div class="container">
            <div class="product-display">
                <div class="searchbar">
                    <form action="" method="get">
                        <button type="submit" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input type="search" name="" class="searchInput" placeholder="Search for Orders">
                    </form>
                </div>
                <div class="table-container">
                    <table class="product-display-table">
                        <thead>
                            <tr>
                                <th>CUSTOMER ID</th>
                                <th>CUSTOMER Name</th>
                                <th>CUSTOMER ADDRESS</th>
                                <th>ORDERS</th>
                                <th>TOTAL SPENT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($orders) && !empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['cus_id']) ?></td>
                                        <td><?= htmlspecialchars($order['cus_fname']) . ' ' . htmlspecialchars($order['cus_lname']) ?></td>
                                        <td><?= htmlspecialchars($order['customer_address'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($order['orders_count'] ?? 0) ?></td>
                                        <td><?= number_format($order['total_spent'] ?? 0.00, 2) ?></td>
                                        <td>
                                            <a href="<?= ROOT ?>CustomerDetails?cus_id=<?= htmlspecialchars($order['cus_id']) ?>" class="view">
                                                <i class="fa-solid fa-info"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="totalproduct">
                    <p class="tottext">Total Customer: <?= count($orders) ?></p>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?= ASSETS ?>js/customer.js"></script>
    <script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
