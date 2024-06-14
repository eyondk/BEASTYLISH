<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="<?= ASSETS ?>css/dashboard.css">
    <title>DashBoard</title>
</head>

<body>
    <?php include 'admin_header.php'; ?>
    <section class="home">
        <div class="text">DASHBOARD</div>
        <hr id="line" />
        <div class="main">
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($data['today_sales']) ?></div>
                        <div class="card-name">Today Sales</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($data['total_sales']) ?></div>
                        <div class="card-name">Total Sales</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($data['today_revenue']) ?></div>
                        <div class="card-name">Today Revenue</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number"><?= htmlspecialchars($data['total_revenue']) ?></div>
                        <div class="card-name">Total Revenue</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
            </div> 

            <div class="charts">
                <div class="chart">
                    <input type="hidden" name="chart" id="chart" 
                        data-chartsales='<?= htmlspecialchars(json_encode($data['monthly_sales'])) ?>'
                        data-chartrevenue='<?= htmlspecialchars(json_encode($data['monthly_revenue'])) ?>'
                        data-chartweeksales='<?= htmlspecialchars(json_encode($data['weekly_sales'])) ?>'
                        data-chartweekrevenue='<?= htmlspecialchars(json_encode($data['weekly_revenue'])) ?>'>
                    <select id="chartViewSelector">
                        <option value="monthly">Monthly</option>
                        <option value="weekly">Weekly</option>
                    </select>
                    <h2>Total Sales</h2>
                    <canvas id="TotalSales"></canvas>
                </div>
                <div class="chart">
                    <h2>Total Revenue</h2>
                    <canvas id="TotalRevenue"></canvas>
                </div>
            </div>

    

            <!-- Table for Top Products with Most Sales -->
            <div class="top-products">
                <h2>Top Products with Most Sales</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Sales</th>
                            <th scope="col">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data['top_products'])): ?>
                <?php foreach ($data['top_products'] as $index => $product): ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= htmlspecialchars($product['prod_name']) ?></td>
                        <td><?= htmlspecialchars($product['total_sales']) ?></td>
                        <td><?= htmlspecialchars('$' . number_format($product['total_revenue'], 2)) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No products found.</td>
                    </tr>
                <?php endif; ?> 
                    </tbody>
                </table>
            </div>
        </div>     
    </section>
    
    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@2.24.0/dist/date-fns.min.js"></script>

    <!-- Include custom scripts -->
    <script src="<?= ASSETS ?>js/dashboard.js"></script>
    <script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
