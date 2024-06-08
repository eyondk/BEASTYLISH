<link rel="stylesheet" href="css/cart2.css">

<?php require('user_header.inc.php')?>

<div class="tt">
    <h1>SHOPPING CART</h1>
</div>
<main class="mainCart">
    

    <div class="cart">
        <div class="product-display">
            <div class="table-container">
                <table class="product-display-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th >Product</th>
                            <th >Price</th>
                            <th >Quantity</th>
                            <th >SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <form action="/Customer/DeleteFromCart" method="post">
                                <input type="hidden" name="id" value="@item.DES_ID" />
                                <button type="submit" class="delete" >&times;</button>
                            </form>

                        </td>
                        <td>
                           <img src="img/profile3.jpg" alt="product" width="100" height="100">
                        </td>
                        <td>@item.DES_NAMdnsdbndE</td>
                        <td>&#8369; 680.00</td>
                        <td>
                                <div class="qty-container">
                                    <div class="wrapper">
                                        <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                        <input type="number" min="1" name="" id="quantity" class="num" value="1">
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                        </td>
                        <td>&#8369; 680.00</td>
                    </tr>

                    <tr>
                        <td class="deletetd"> 
                            <form action="/Customer/DeleteFromCart" method="post">
                                <input type="hidden" name="id" value="@item.DES_ID" />
                                <button type="submit" class="delete" >&times;</button>
                            </form>

                        </td>
                        <td>
                           <img src="img/profile3.jpg" alt="product" width="100" height="100">
                        </td>
                        <td>@item.DES_NAMdndsajdjgajsdbndE</td>
                        <td>&#8369; 680.00</td>
                        <td>
                                <div class="qty-container">
                                    <div class="wrapper">
                                        <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                        <input type="number" min="1" name="" id="quantity" class="num" value="1">
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                        </td>
                        <td>&#8369; 680.00</td>
                    </tr>

                    <tr>
                        <td>
                            <form action="/Customer/DeleteFromCart" method="post">
                                <input type="hidden" name="id" value="@item.DES_ID" />
                                <button type="submit" class="delete" >&times;</button>
                            </form>

                        </td>
                        <td>
                           <img src="img/profile3.jpg" alt="product" width="100" height="100">
                        </td>
                        <td>@item.DES_NAMdnsdbndE</td>
                        <td>&#8369; 680.00</td>
                        <td>
                                <div class="qty-container">
                                    <div class="wrapper">
                                        <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                        <input type="number" min="1" name="" id="quantity" class="num" value="1">
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                        </td>
                        <td>&#8369; 680.00</td>
                    </tr>
                   
                    <tr>
                        <td>
                            <form action="/Customer/DeleteFromCart" method="post">
                                <input type="hidden" name="id" value="@item.DES_ID" />
                                <button type="submit" class="delete" >&times;</button>
                            </form>

                        </td>
                        <td>
                           <img src="img/profile3.jpg" alt="product" width="100" height="100">
                        </td>
                        <td>@item.DES_NAMdnsdbndE</td>
                        <td>&#8369; 680.00</td>
                        <td>
                                <div class="qty-container">
                                    <div class="wrapper">
                                        <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                        <input type="number" min="1" name="" id="quantity" class="num" value="1">
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                        </td>
                        <td>&#8369; 680.00</td>
                    </tr>

                    <tr>
                        <td>
                            <form action="/Customer/DeleteFromCart" method="post">
                                <input type="hidden" name="id" value="@item.DES_ID" />
                                <button type="submit" class="delete" >&times;</button>
                            </form>

                        </td>
                        <td>
                           <img src="img/profile3.jpg" alt="product" width="100" height="100">
                        </td>
                        <td>@item.DES_NAMdnsdbndE</td>
                        <td>&#8369; 680.00</td>
                        <td>
                                <div class="qty-container">
                                    <div class="wrapper">
                                        <button class="minus" style="color:#6c4a2186;" disabled>-</button>
                                        <input type="number" min="1" name="" id="quantity" class="num" value="1">
                                        <button class="plus">+</button>
                                    </div>
                                </div>
                        </td>
                        <td>&#8369; 680.00</td>
                    </tr>


                </tbody>
                </table>
            </div>
            <div>
                <form action="" method="post">
                    <input type="submit" class="deleteall" value="DELETE ALL ITEMS">
                </form>
            </div>

        </div>


        <div class="cartTotals">
            <div class="carttot">
                <p class="cart-tit">
                    Cart totals
                </p>

                <div class="subtot">
                    <p>Subtotal (3 Items)</p>
                    <p>&#x20B1; 90.05</p>
                </div>

                <div class="shipping">
                    <p>Delivery Fee</p>
                    <p>&#x20B1; 90.00</p>
                </div>

                <div class="Discount">
                    <p>Discount Fee</p>
                    <p>&#x20B1; 100</p>
                </div>

                <div class="total">
                    <p>Total</p>
                    <p>&#x20B1; @total</p>                                                     
                </div>

                <div class="button">
                    <button type="button" class="add-btn" id="proceedtocheckout">Proceed To Checkout</button>
                    
                </div>

            </div>
        </div>

        
    </div>

    


</main>

<script src="js/cart.js"></script>

