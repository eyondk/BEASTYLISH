<?php include('admin_header.php'); ?>
<link rel="stylesheet" href="css/adminproduct.css">
<section class="home">
    <div class="container">
        <div class="product-display">
            <div class="searchbar">
                <form action="" method="get">
                    <button type="submit" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" name="" id="" class="searchInput" placeholder="Search for Orders">
                </form>
            </div>
            <div class="table-container">
                <table class="product-display-table">
                    <thead>
                        <tr>
                            <th>ORDER ID</th>
                            <th>ORDER DATE</th>
                            <th>CUSTOMER NAME</th>
                            <th>TOTAL COST</th>
                            <th>PAYMENT METHOD</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>11111</td>
                            <td>10-11-2013</td>
                            <td>Sample NameAdd</td>
                            <td>&#8369; 700.00</td>
                            <td>COD</td>
                            <td>
                                <select name="order_status" class="box">
                                    <option value="1">Pending</option>
                                    <option value="2">On Delivery</option>
                                    <option value="3">Completed</option>
                                    <option value="4">Cancelled</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="view" data-order-id="11111" data-customer-name="Sample NameAdd" data-phone="0928298203" data-email="name@gmail.com" data-address="sitio Pangpang Nalumos City">
                                    <i class="fa-solid fa-info"></i> View Details
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="totalproduct">
                <p class="tottext">TOTAL ORDERS: 800</p>
            </div>
        </div>
    </div>
</section>

<!-- View product Modal -->
<div id="viewProdModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <h2>ORDER DETAILS</h2>
        <div class="order-info">
            <p><strong>Order ID:</strong> <span id="orderID">1111</span></p>
            <p><strong>Name:</strong> <span id="customerName">Sample NameAdd</span></p>
            <p><strong>Phone Number:</strong> <span id="phoneNumber">0928298203</span></p>
            <p><strong>Email:</strong> <span id="email">name@gmail.com</span></p>
            <p><strong>Address:</strong> <span id="address">sitio Pangpang Nalumos City</span></p>
        </div>
        <div class="products-info">
            <h3>Products Ordered</h3>
            <div id="productsContainer">
                <!-- Loop to dynamically add products -->
                <p><strong>Product Name:</strong> dhgjaghdja</p>
                <p><strong>Quantity:</strong> 37</p>

                <p><strong>Product Name:</strong> dhgjaghdja</p>
                <p><strong>Quantity:</strong> 37</p>

                <p><strong>Product Name:</strong> dhgjaghdja</p>
                <p><strong>Quantity:</strong> 37</p>
            </div>
            <p><strong>Total Items Ordered:</strong> <span id="totalItems">74</span></p>
            <p><strong>Status:</strong> <span id="orderStatus">Pending</span></p>
        </div>
    </div>
</div>

<script src="js/addproduct.js"></script>
