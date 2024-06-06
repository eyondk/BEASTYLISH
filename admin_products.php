<?php include('admin_header.php');?>
<link rel="stylesheet" href="css/adminproduct.css">
<section class="home">
    <div class="searchbar">
        <form action="" method="get">
            <button type="submit" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
            <input type="search" name="" id="" class="searchInput" placeholder="Search for Products">
        </form>
    </div>
    <div class="container">
        <div class="product-display">
            <div class="table-container">
                <table class="product-display-table">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Description</th>
                            <th>Product Stocks</th>
                            <th>Product Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="img/profile2.jpg" height="100" width="100"></td>
                            <td>Sample Name</td>
                            <td>&#8369; 700.00</td>
                            <td>Sample Description HAGDJASJAJXVHCJHJAVJDKJSHAKKAJEGHDJHBJDCGHUDBMBXAHDASCYSHINEEEEEEEEEEEEEEEE IT'S YOU RGOLDEN ARMS</td>
                            <td>Sample Stocks</td>
                            <td>Sample Category</td>
                            <td>
                                <button type="submit" class="btns edit" id="editbtn"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletebtn"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="totalproduct">
                <p class="tottext">Total Products: 800</p>
            </div>
        </div>
        <button type="submit" class="btns add" id="addmodal">Add Product</button>
    </div>
</section>

<!-- Add product Modal -->
<div id="addProdModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="closemodal">&times;</span>
    <h1>ADD NEW PRODUCTS</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Enter Product Name" name="product_name" class="box">
        <input type="number" placeholder="Price" step=".01" min="1" name="product_price" class="box">
        <input type="text" placeholder="Description" name="product_description" class="box">
        <input type="number" placeholder="Stocks" min="1" name="product_stocks" class="box">
        <select  name="product_category" class="box">
            <option value="1">Shirt</option>
            <option value="2">Pants</option>
            <option value="3">Boquet</option>
        </select>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
        <input type="submit" class="add-btn" name="add_product" value="ADD PRODUCT">
        <input type="button"  class="opt-btn" id="optionbtn" value="GO BACK">
    </form>
  </div>

</div>



<!-- Edit product Modal -->
<div id="editProdModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="closemodal">&times;</span>
    <h1>EDIT PRODUCTS</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Enter Product Name" name="product_name" class="box">
        <input type="number" placeholder="Price" step=".01" min="1" name="product_price" class="box">
        <input type="text" placeholder="Description" name="product_description" class="box">
        <input type="number" placeholder="Stocks" min="1"  name="product_stocks" class="box">
        <select  name="product_category" class="box">
            <option value="1">Shirt</option>
            <option value="2">Pants</option>
            <option value="3">Boquet</option>
        </select>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
        <input type="submit" class="add-btn" name="add_product" value="SAVE">
        <input type="button"  class="opt-btn"id="optionbtn" value="CANCEL">
    </form>
  </div>

</div>

<!-- Delete product Modal -->
<div id="deleteProdModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="closemodal">&times;</span>
    <h1><i class="fa-solid fa-triangle-exclamation"></i></h1>
    <h1>DELETE PRODUCT</h1>
    <h5>Are you sure you want to delete product name "$productName"?</h5> <!-- <?php echo htmlspecialchars($productName); ?>"? ?> -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="submit" class="add-btn" name="add_product" value="YES, DELELET IT!">
        <input type="button"  class="opt-btn"id="optionbtn" value="NO, KEEP IT.">
    </form>
  </div>

</div>
<script src="js/addproduct.js"></script>
