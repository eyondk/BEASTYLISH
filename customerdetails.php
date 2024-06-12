<?php include "admin_header.php"?>

<link rel="stylesheet" href="css/customerdetails.css">
<section class="home">

    <div class="semiheader">
        
        <h2>CUSTOMER ID #89</h2>

        <div class="delete-div">
            <input type="button" class="cus-dlt-btn" value="DELETE CUSTOMER">
        </div>        
    </div>

    <div class="customerdetails-container">
            


            <div class="customerdetails-card">
                <div class="pic-name-id">
                    <img src="img/11.png" alt="" srcset="" width="200" height="200">
                    <h3 class="full-name">Nami Dalocanog</h3>
                    <h4>Customer Id #89</h4>
                </div>

                <div class="customerdetails-info">
                    <div class="orders-div">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="orderdet">
                            <h4 class="total-order">8463</h4>
                            <h5 class="tit">Orders</h5>
                        </div>
                    </div>

                    <div class="cus-det">
                        <h3><strong>Username:</strong> Namiswan</h3>
                        <h3><strong>Email:</strong> name@gmail.com</h3>
                        <h3><strong>Phone Number:</strong> 0928298203</h3>
                        <h3><strong>Address:</strong> Sitio Pangpang Nalumos</h3>
                    </div>
                </div>
            </div>

            <div class="orderdetails-card">
                <h3> Order ID: 11111</h3>
                <h4>Order Status: Pending</h4>

                <div class="order-details-table-wrapper">
                    <table class="order-details-table">
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="img/12.png" alt="Product Image" width="100" height="100"></td>
                                <td>Product Name</td>
                                <td>2</td>
                                <td>&#8369; 20.00</td>
                            </tr>
                            
                            <!-- Additional rows can be added here for more products -->
                        </tbody>
                    </table>
                </div>

                <div class="order-summary">
                    <h4>Order Summary</h4>
                    <p>Total Price: &#8369;40.00</p>
                    <p>Discount: &#8369;5.00</p>
                    <p>Delivery Fee: &#8369;10.00</p>
                    <p>Payment Method: GCASH</p>
                    <p>Shipping Address: 123 Shipping Lane, Shipping City, Shipping State, Shipping Zip</p>
                </div>
            </div>


           


    </div>

    <div class="semifooter">
        <a href="#" class="back">         
            &#10230; BACK TO ORDERS
        </a>
    </div>

</section>