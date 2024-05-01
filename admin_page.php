<?php
    include 'config.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:login.php');
    }
?>

<?php include'admin_header.php';?>

<section class="home">

</section>
