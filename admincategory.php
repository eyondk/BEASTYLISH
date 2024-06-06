<?php include('admin_header.php'); ?>
<link rel="stylesheet" href="css/adminproduct.css">
<link rel="stylesheet" href="css/admincategory.css">
<section class="home">
    <div class="tittle">
        <h1>PRODUCT CATEGORY</h1>
    </div>

    <div class="secbod">
            <div class="searchbar">
                <form action="" method="get">
                    <button type="submit" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="search" name="" id="" class="searchInput" placeholder="Search for Category">
                </form>
            </div>

            <div class="table-container">
                <table class="product-display-table">
                    <thead>
                        <tr>
                            <th>CATEGORIES</th>
                            <th>PRODUCTS STOCKS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bottom</td>
                            <td>11111</td>
                            <td>
                                <button type="submit" class="btns edit" id="editcatmodal"><i class="fas fa-edit"></i> Edit</button>
                                <button type="reset" class="btns delete" id="deletecatmodal"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="totalcategory">
                <h2 class="tottext">TOTAL CATEGORIES: 5</h2>
            </div>
            <button type="submit" class="addbtn" id="addcatmodal">Add Product</button>

    </div>
</section>

<!-- Add category Modal -->
<div id="addCatModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="closemodal">&times;</span>
    <h1>ADD NEW CATEGORY</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Enter New Category" name="category" class="box">
        <input type="submit" class="add-btn" name="add_cat" value="ADD CATEGORY">
        <input type="button"  class="opt-btn" id="optionbtn" value="GO BACK">
    </form>
  </div>
</div>


<!-- Edit category  Modal -->
<div id="editCatModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="closemodal">&times;</span>
    <h1>EDIT CATEGORY</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Enter New Category" name="category" class="box">
        <input type="submit" class="add-btn" name="add_cat" value="ADD CATEGORY">
        <input type="button"  class="opt-btn" id="optionbtn" value="GO BACK">
    </form>
  </div>
</div>


<!-- Delete category Modal -->
<div id="deleteCatModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="closemodal">&times;</span>
    <h1><i class="fa-solid fa-triangle-exclamation"></i></h1>
    <h1>DELETE PRODUCT</h1>
    <h5>Are you sure you want to delete category name "$categoryName"?</h5> <!-- <?php echo htmlspecialchars($productName); ?>"? ?> -->
    <form action="" method="post" enctype="multipart/form-data">
        <input type="submit" class="add-btn" name="add_product" value="YES, DELELET IT!">
        <input type="button"  class="opt-btn"id="optionbtn" value="NO, KEEP IT.">
    </form>
  </div>

</div>

<script src="js/addcategory.js"></script>