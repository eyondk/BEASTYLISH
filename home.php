<?php
    include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

<?php include("home_header.inc.php");?>
    
</body>
</html>
