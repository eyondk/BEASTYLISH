
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | Beastylish</title>
    <link rel="shortcut icon" href="<?=ROOT?>/assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/account.css">
</head>
<body>
    <?php require("shared/header.inc.php")?>

    <section class="account">
        <div class="account-sidebar">
            <div class="profile">
                
            <?php if (isset($_SESSION['user_profile']) && !empty($_SESSION['user_profile'])): ?>
                <img src="<?= ROOT . htmlspecialchars($_SESSION['user_profile']) ?>" height="100" alt="Profile Picture">
            <?php endif; ?>

            <p class="name"><?= isset($_SESSION['user_username']) ? htmlspecialchars($_SESSION['user_username']) : '' ?></p>

            </div>
            
            <ul>
                <a id="account-info-link"><i class="fas fa-user"></i><span>ACCOUNT INFO</span></a>
                <a id="address-link"><i class="fas fa-map-marker-alt"></i><span>ADDRESS</span></a>
                <a id="orders-link"><i class="fas fa-shopping-cart"></i><span>ORDERS</span></a>
                <a id="faq-link"><i class="fas fa-info-circle"></i><span>POLICY & FAQ</span></a>
                <a id="change-pass-link"><i class="fas fa-key"></i><span>CHANGE PASS</span></a>
                <a onclick="logout()"><i class="fas fa-sign-out-alt"></i><span>LOG OUT</span></a>
            </ul>
        </div>

            <?php if (isset($errors) && !empty($errors)): ?>
               <div class="conatiner">
                    <div class="error-messages ">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
               </div>
            <?php endif; ?>

        <div class="acc_info">
            

            <form class="user_details" action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                    <div class="inputBox">
                        <span>USER NAME</span>
                        <input type="text" id="username" name="username" class="box" value="<?= isset($_SESSION['user_username']) ? htmlspecialchars($_SESSION['user_username']) : '' ?>" disabled>
                        <span>FULL NAME</span>
                        <input type="text" name="fname" class="box" value="<?= isset($_SESSION['user_fname']) ? htmlspecialchars($_SESSION['user_fname']) : '' ?> <?= isset($_SESSION['user_lname']) ? htmlspecialchars($_SESSION['user_lname']) : '' ?>" disabled>
                        <span>EMAIL</span>
                        <input type="email" name="email" class="box" value="<?= isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : '' ?>" disabled>
                        <span>PHONE NUMBER</span>
                        <input type="text" name="phone" class="box" value="<?= isset($_SESSION['user_phonenumber']) ? htmlspecialchars($_SESSION['user_phonenumber']) : '' ?>" disabled>
                        <span>SEX</span>
                        <input type="text" name="sex" class="box" value="<?= isset($_SESSION['user_sex']) ? htmlspecialchars($_SESSION['user_sex']) : '' ?>" disabled>
                    </div>
                </div>
                <div class="flex">
                    <a href="#" class="btn">EDIT INFO</a>
                </div>
            </form>


            <form class="edit_acc" action="<?=ROOT?>/Account/updateAccount" method="POST" enctype="multipart/form-data" style="display: none;">
                <div class="flex">
                    <div class="inputBox">
                        <span>UPDATE PROFILE</span>
                        <input type="file" id="updateprofile" name="updateprofile" accept="image/jpg, image/jpeg, image/png" placeholder="Update profile picture" class="box">
                        <span>UPDATE FIRST NAME</span>
                        <input type="text" name="updatefname" class="box"  placeholder="Update first name">
                        <span>UPDATE LAST NAME</span>
                        <input type="text" name="updatelname" class="box"  placeholder="Update last name">
                        <span>UPDATE USERNAME</span>
                        <input type="text" name="updateusername" class="box" placeholder="Update username" >
                        <span>UPDATE EMAIL </span>
                        <input type="email" name="email" placeholder="Update email" class="box">
                        <span>UPDATE PHONE NUMBER</span>
                        <input type="tel" name="updatephonenum" class="box" placeholder="Update phone number" 
                        pattern="(\+639|09)\d{9}"  title="Sample phone number: +639xxxxxxxxx or 09xxxxxxxxx" >
                        <span>UPDATE SEX</span>
                        <select class="box" name="updatesex" id="updatesex" required>
                            <option value="" disabled selected>Sex</option>
                            <option value="FEMALE">Female</option>
                            <option value="MALE">Male</option>
                        </select>                   
                    </div>
                </div>
                <div class="flex">
                    <input type="submit" class="btn" value="UPDATE" name="update_profile" >
                    <a class="option-btn">BACK</a>
                </div>
            </form>
        </div>

       <div class="changePass" style="display: none;">
            <form class="changepassForm" action="<?=ROOT?>/Account/updatePassword" method="POST" enctype="multipart/form-data">
                <div class="flex">
                        <div class="inputBox">
                            <span>OLD PASSWORD </span>
                            <input type="password" name="oldpass" class="box" placeholder="Enter old password" required>
                            <span>NEW PASSWORD </span>
                            <input type="password" name="updatepass" class="box" placeholder="Enter old password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            <span>CONFIRM NEW PASSWORD </span>
                            <input type="password" name="confirmpass" class="box" placeholder="Confirm new password" required>
                        </div>
                </div>
                <div class="flex">
                    <input type="submit" class="btn" value="UPDATE PASSWORD" name="update_profile" >
                </div>
            </form>
       </div>

        
                
        <div class="addressSec" style="display: none;">
            <form class="address_details" action="" method="POST" enctype="multipart/form-data">
                <div class="flex">
                    <div class="inputBox">
                        <span>STREET</span>
                        <input type="text" name="street" class="box" value="<?= isset($_SESSION['user_street']) ? htmlspecialchars($_SESSION['user_street']) : '' ?>" disabled>
                        <span>CITY</span>
                        <input type="text" name="city" class="box" value="<?= isset($_SESSION['user_city']) ? htmlspecialchars($_SESSION['user_city']) : '' ?>" disabled>
                        <span>PROVINCE</span>
                        <input type="text" name="province" class="box" value="<?= isset($_SESSION['user_province']) ? htmlspecialchars($_SESSION['user_province']) : '' ?>" disabled>
                        <span>MESSAGE</span>
                        <input type="text" name="mess" class="box" value="<?= isset($_SESSION['user_infoaddress']) ? htmlspecialchars($_SESSION['user_infoaddress']) : '' ?>" disabled>
                    </div>
                </div>
                <div class="flex">
                    <a href="#" class="edit_add">EDIT ADDRESS</a>
                </div>
            </form>

            <form class="edit_address" action="<?=ROOT?>/Account/updateAddress" method="POST" enctype="multipart/form-data" style="display: none;">
                <div class="flex">
                    <div class="inputBox">
                        <input type="text" name="updatestreet" class="box" placeholder="Street" >
                        <select class="box" name="updatecity" id="city" >
                            <option value="" disabled selected>City</option>
                            <option value="BOGO CITY">Bogo City</option>
                            <option value="CAR CITY">Carcar City</option>
                            <option value="CEBU CITY">Cebu City</option>
                            <option value="DANAO CITY">Danao City</option>
                            <option value="LAPU-LAPU CITY">Lapu-lapu City</option>
                            <option value="MANDAUE CITY">Mandaue City</option>
                            <option value="NAGA CITY">Naga City</option>
                            <option value="TALISAY CITY">Talisay City</option>
                            <option value="TOLEDO CITY">Toledo City</option>
                        </select>
                        <select class="box" name="updateprovince" id="province" >
                            <option value="" disabled selected>Province</option>
                            <option value="CEBU">Cebu</option>
                        </select>
                        <input type="text" name="message" class="box" placeholder="Add message (optional)">


                    </div>
                </div>
                <div class="flex">
                    <input type="submit" class="save_upd_add" value="UPDATE" name="update_address">
                    <a class="back-btn">BACK</a>
                </div>
            </form>
        </div>


       <div class="orders" style="display: none;">
            <div class="order-container">
                <p>MY ORDERS</p>
                <div class="orderstatus">
                    <input type="submit" name="" id="" value="PENDING">
                    <input type="submit" name="" id="" value="ON SHIPPED">
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


        <div class="faqSection" style="display: none;">
            <div class="title-faqs">
                <h2>FAQs</h2>
                <h3>Frequently Ask Questions</h3>
                <h3>Here are some common questions about Be'astylish</h3>
            </div>
            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleAnswer(this)">
                        <span>Do you have a physical store location where I can shop in person?</span>
                        <span class="plus-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we are located at Sitio Kamanggahan Tabok Mandaue City.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleAnswer(this)">
                        <span>What payment methods do you accept?</span>
                        <span class="plus-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We accept COD via Maxim, Gcash, or Meet up with minimum purchase of 100.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleAnswer(this)">
                        <span>Are there any special discounts for bulk or wholesale orders?</span>
                        <span class="plus-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we provide discounts on selected holidays, anniversary and also for bulk orders(negotiable).</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleAnswer(this)">
                        <span>Can I request a personalized message to be included with my order?</span>
                        <span class="plus-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, you can request a personalized message to be included with your order.</p>
                    </div>
                </div>
                <!-- Add more FAQ items as needed -->
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

    <!-- logout modal -->
    <div id="logoutModal" class="modal" style="display: none;">
        <div class="modal-content">
            <form action="<?= ROOT ?>/Account/logout" method="post">
                <div class="cancel-container">
                    <div class="cancel">
                        <h3>LOG OUT</h3>
                        <h4>Are you sure you want to logout?</h4>
                    </div>
                    <div class="btns">
                        <input type="button" class="back" value="CANCEL" onclick="closeModal()">
                        <input type="submit" class="logoutbtn" value="YES, LOG OUT">
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="<?=ROOT?>/assets/js/order.js"></script>
    <script src="<?=ROOT?>/assets/js/account.js"></script>
    <script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
</body>
</html>
