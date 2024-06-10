<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/dashboard.css">
    <title>DashBoard</title>
</head>

<body>
    <?php include 'admin_header.php';?>
    <section class="home">
        <div class="text">DASHBOARD</div>
        <hr id="line" />
        <div class="main">
            <div class="cards">
                <div class="card">
                    <div class="card-content">
                        <div class="number">1215</div>
                        <div class="card-name">Today Sales</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">1215</div>
                        <div class="card-name">Total Sales</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">1215</div>
                        <div class="card-name">Today Revenue</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="number">1215</div>
                        <div class="card-name">Total Revenue</div>     
                    </div>
                    <div class="icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
            </div> 

            <div class="charts">
                <div class="chart">
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
                        <!-- Sample Data Rows -->
                        <tr>
                            <th scope="row">1</th>
                            <td>Product A</td>
                            <td>500</td>
                            <td>$2500</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Product B</td>
                            <td>300</td>
                            <td>$1500</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Product C</td>
                            <td>200</td>
                            <td>$1000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>     
    </section>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="<?=ASSETS?>js/chart1.js"></script>
<script src="<?=ASSETS?>js/chart2.js"></script>
<script src="<?=ASSETS?>js/admin.js"></script>
</html>
