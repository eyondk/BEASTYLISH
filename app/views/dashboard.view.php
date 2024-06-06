

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../../public/assets/css/dashboard.css">

    <title>DashBoard</title>

</head>

<body>

    <section class="home">

        <div class="text">DASHBOARD</div>
        <hr id = "line" />
        <div class = "main">
            <div class = "cards">
                <div class = "card">
                    <div class = "card-content">
                        <div class = "number">1215</div>
                        <div class = "card-name">Today Sales</div>     
                    </div>
                    <div class = "icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class = "card">
                    <div class = "card-content">
                        <div class = "number">1215</div>
                        <div class = "card-name">Total Sales</div>     
                    </div>
                    <div class = "icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class = "card">
                    <div class = "card-content">
                        <div class = "number">1215</div>
                        <div class = "card-name">Today Revenue</div>     
                    </div>
                    <div class = "icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
                <div class = "card">
                    <div class = "card-content">
                        <div class = "number">1215</div>
                        <div class = "card-name">Total Revenue</div>     
                    </div>
                    <div class = "icon-box">
                        <i class="fa-solid fa-money-bill"></i>
                    </div> 
                </div>
            </div> 
            <div class="charts">
                <div class="chart">
                    <h2>Total Sale</h2>
                    <canvas id="TotalSales"></canvas>
                </div>
                <div class="chart">
                    <h2>Total Revenue</h2>
                    <canvas id="TotalRevenue"></canvas>
                </div>

            </div>
        </div>     
        
    </section>
    <?php include 'shared/admin_header.php';?>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="<?=ASSETS?>js/chart1.js"></script>
<script src="<?=ASSETS?>js/chart2.js"></script>
<script src="<?=ASSETS?>js/admin.js"></script>
</html>