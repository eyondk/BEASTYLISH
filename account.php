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
    <title>Account | Beastylish</title>
    <link rel="shortcut icon" href="img/Beastylish-favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/account.css">
</head>
<body>
    <?php require("user_header.inc.php")?>

    <section class="account">
        <div class="account-sidebar">
            <div class="profile">
                <img src="img/profile1.jpg" alt="profile picture">
                <p class="name">RIZZA MI LOIUSE OLIVER</p>
            </div>
            
            <ul>
                <a id="account-info-link"><i class="fas fa-user"></i><span>ACCOUNT INFO</span></a>
                <a id="orders-link" id=""><i class="fas fa-shopping-cart"></i><span>ORDERS</span></a>
                <a href="#"><i class="fas fa-info-circle"></i><span>POLICY & FAQ</span></a>
                <a id="change-pass-link"><i class="fas fa-key"></i><span>CHANGE PASS</span></a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span>LOG OUT</span></a>
            </ul>
        </div>

       <div class="acc_info">
            <form class="user_details" action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                    <div class="inputBox">
                        <span>PROFILE PICTURE</span>
                        <input type="file" id="dp" name="dp" accept="image/jpg, image/jpeg, image/png" class="box" disabled>
                        <input type="hidden" name="old_img">
                        <span>FULL NAME</span>
                        <input type="text" name="fname" class="box" disabled>
                        <span>USERNAME</span>
                        <input type="text" name="username" class="box" disabled>
                        <span>CONTACT NUMBER</span>
                        <input type="text" name="contact" class="box" disabled>
                        <span>SEX</span>
                        <input type="text" name="sex" class="box" disabled>                    
                    </div>
                    <div class="inputBox">
                        <span>EMAIL </span>
                        <input type="email" name="email" class="box" disabled>
                        <span>ADDRESS</span>
                        <input type="text" name="add"  class="box" disabled>      
                        <span>CITY</span>
                        <input type="text" name="city"  class="box" disabled>
                        <span>COUNTRY</span>
                        <input type="text" name="city" class="box" disabled>
                        <span>ZIP CODE</span>
                        <input type="text" name="zipcode" class="box" disabled>
                    </div>
                </div>
                <div class="flex">
                    <a href="admin_page.php" class="btn">EDIT INFO</a>
                </div>
            </form>
                   
       
       
            <form class="edit_acc" action="" method="POST" enctype="multipart/form-data" style="display: none;">
                <div class="flex">
                    <div class="inputBox">
                        <span>PROFILE PICTURE</span>
                        <input type="file" id="dp" name="dp" accept="image/jpg, image/jpeg, image/png" placeholder="Update profile picture" class="box">
                        <input type="hidden" name="old_img">
                        <span>FULL NAME</span>
                        <input type="text" name="fname" placeholder="Update full name" class="box">
                        <span>USERNAME</span>
                        <input type="text" name="username" placeholder="Update username" class="box">
                        <span>CONTACT NUMBER</span>
                        <input type="text" name="contact" placeholder="Update contact number" class="box">
                        <span>SEX</span>
                        <input type="text" name="sex" placeholder="Update sex" class="box">                    
                    </div>
                    <div class="inputBox">
                        <span>EMAIL </span>
                        <input type="email" name="email" placeholder="Update email" class="box">
                        <span>ADDRESS</span>
                        <input type="text" name="add"  placeholder="Update address" class="box">      
                        <span>CITY</span>
                        <input type="text" name="city"  placeholder="Update city" class="box">
                        <span>COUNTRY</span>
                        <input type="text" name="city" placeholder="Update country" class="box">
                        <span>ZIP CODE</span>
                        <input type="text" name="zipcode" placeholder="Update zip code" class="box">
                    </div>
                </div>
                <div class="flex">
                    <input type="submit" class="btn" value="UPDATE" name="update_profile" >
                    <a class="option-btn">BACK</a>
                </div>
            </form>
       </div>

       <div class="changePass" style="display: none;">
            <form class="changepassForm" action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                        <div class="inputBox">
                            <input type="hidden" name="old_pass">
                            <span>OLD PASSWORD </span>
                            <input type="password" name="update_pass"  placeholder="Enter previous password" class="box">
                            <span>NEW PASSWORD </span>
                            <input type="password" name="new_pass"  placeholder="Enter new password" class="box">
                            <span>CONFIRM NEW PASSWORD </span>
                            <input type="password" name="confirm_pass"  placeholder="Confirm new password" class="box">
                        </div>
                </div>
                <div class="flex">
                    <input type="submit" class="btn" value="UPDATE PASSWORD" name="update_profile" >
                </div>
            </form>
       </div>

       
       <div class="orders" style="display: none;">
            <div class="order-container">
                <p>MY ORDERS</p>
                <div class="orderstatus">
                    <input type="submit" name="" id="" value="PENDING">
                    <input type="submit" name="" id="" value="ON DELIVERY">
                    <input type="submit" name="" id="" value="COMPLETED">
                    <input type="submit" name="" id="" value="CANCELLED">
                </div>            
                <div class="order">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Total Cost</th>
                                <th>Ordered Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12345</td>
                                <td>&#8369; 99.00</td>
                                <td>2024-06-12</td>
                                <td>Pending</td>
                                <td>
                                    <button class="view" onclick="viewDetails(12345)">View Details</button> /
                                    <button type="submit" class="modify" onclick="modifyOrder(12345)">MODIFY</button> /
                                    <button class="cancel" onclick="cancelOrder(12345)">Cancel</button>
                                    
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


 
    </section>  

        
    <!-- view order details modal -->
    <div id="detailsModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="o">
                <h4>Order Summary</h4>
                <p class="oo">Total Price: &#8369; 40.00</p>
            </div>
            <div class="orderssummary">
                <div class="r">
                    <p class="tt"><strong>Total Items:</strong> 90</p>
                    <p class="tt"><strong>Total Discount:</strong> &#8369; 5.00</p>
                </div>

                <div class="r">
                    <p class="tt"><strong>Delivery Fee:</strong> &#8369; 5.00</p>
                    <p class="tt"><strong>Payment Method:</strong> GCASH</p>
                </div>   
            </div>
            <div class="i">
                <p class="tt"><strong>Receiver:</strong> Christine Jade Duran</p>
                <p class="tt"><strong>Shipping Address:</strong> 123 Shipping Lane, Shipping City, Shipping State, Shipping Zip</p>
            </div>

            <div class="table-container">
                <table class="details-table">
                    <tbody>
                    
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        <tr>
                            <td>
                                    <img src="img/meetup icon.png" alt="Product Image" width="50" height="50">
                            </td>
                            <td> Product Name</td>
                            <td>                                
                                &#8369; 90.00
                            </td>
                            <td>4 Items</td>
                        </tr>
                        
                        <!-- Repeat for additional products in the order -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- cancel order modal -->
    <div id="cancelModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="cancel-container">
                <div class="cancel">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i></h2>
                    <h3>CANCEL ORDER</h3>
                    <h4>are you sure you want to cancel this order?</h4>
                </div>
                <div class="btns">
                    <input type="submit"  value="CANCEL ORDER">
                    <input type="button" class="back" value="KEEP ORDER">
                </div>
            </div>
        </div>
    </div>

    <!-- modify order address modal     -->
    <div id="modifyModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="" method="post">
                <h3>Address</h3>
                <div class="form-row">
                    <input type="text" name="street" id="street" placeholder="Street">
                    <input type="text" name="brgy" id="brgy" placeholder="Barangay">
                    <input type="text" name="city" id="city" placeholder="City">
                    <input type="text" name="province" id="province" placeholder="Province">
                </div>

                <div class="modifyBtns">
                    <input type="button" class="back" value="BACK TO ORDER">
                    <input type="submit"  value="UPDATE ADDRESS">
                </div>
            </form>
        </div>

    </div>

    <script src="js/order.js"></script>
    <script src="js/account.js"></script>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
</body>
</html>
