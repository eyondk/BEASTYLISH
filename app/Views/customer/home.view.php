<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Beastylish</title>
    <link rel="shortcut icon" href="<?=ROOT?>/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/home.css">
</head>
<body>

<?php include 'header.inc.php';?>
<section class="home">
    <div class="new">NEW HOME COLLECTION</div>
    <?php include("latestprod.view.php")?>
</section>    
</body>
</html>