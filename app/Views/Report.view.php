


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/report.css">
    <title>Document</title>
</head>
<body>
    <?php include 'admin_header.php';?>
    <section class="home">
        <div class="text">REPORT</div>
        <hr id="line" />
        <div class="container" id="salesReport">
        <div class="report-title">
                <h1>Weekly Sales Report</h1>
            </div>
            <table class="header">
                <tr>
                    <td>WEEK OF</td>
                    <td>ASSOCIATE NAME</td>
                    <td>SIGNATURE</td>
                    <td>REPORT COMPLETION DATE</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            
            <table class="content">
                <tr>
                    <td>PRODUCT</td>
                    <td>MON</td>
                    <td>TUE</td>
                    <td>WED</td>
                    <td>THU</td>
                    <td>FRI</td>
                    <td>SAT</td>
                    <td>SUN</td>
                    <td>TOTAL</td>
                </tr>
                <?php foreach ($report as $row): ?>
                    <tr>
                        <td class="product-description"><?= $row['prod_name'] ?></td>
                        <td><?= $row['mon'] ?></td>
                        <td><?= $row['tue'] ?></td>
                        <td><?= $row['wed'] ?></td>
                        <td><?= $row['thu'] ?></td>
                        <td><?= $row['fri'] ?></td>
                        <td><?= $row['sat'] ?></td>
                        <td><?= $row['sun'] ?></td>
                        <td><?= $row['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <button id="downloadBtn">Download PDF</button>
    </section>
                     
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="<?=ASSETS?>js/report.js"></script>
<script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
