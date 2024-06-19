

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?=ROOT?>/assets/images/logo.png" type="image/x-icon">
    <title>Category</title>
</head>
<body>
<?php include 'admin_header.php';?>
    <section class="home">
        <div class="text">PRODUCT</div>
                    <hr id = "line" />
                    <div class="container">
                        <div class="product-display">
                            <div class="searchbar">
                                <form action="" method="get">
                                    <button type="button" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    <input type="search" name="" id="" class="searchInput" placeholder="Search for Products">
                                </form>
                            </div>
                            <div class="table-container">
                                <table class="product-display-table">
                                    <thead>
                                        <tr>
                                          
                                            <th>Product ID</th>
                                            <th>Product Name</th> 
        
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($categ as $category): ?>
                                        <tr>
                                            
                                        
                                            <td><?= $category['categ_id'] ?></td>
                                            <td><?= $category['categ_name'] ?></td>
                                          
                                            <td>
                                               
                                                <button type="button"   class="btns delete button-delete"  ><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="totalproduct">
                            
                                <p class="tottext">Total Category: <?= count($categ) ?></p>
                            </div>
                        </div>
                        <button type="button" class="btns add" id="addProduct" data-bs-toggle="modal" data-bs-target="#addModal">Add Category</button>
                    </div>
                </section>
                    
                <div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">

                <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modal-title">Add Category</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="message"></div>
                            
                                   
                                    <div class="mb-3">
                                        <label for="categ_name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control form-control-lg fs-6" name="categ_name" id="categ_name" placeholder="Product Name">
                                    </div>
                                  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" id="add_category" name="add_category" class="btn btn-dark" value="add product">Add Category</button>
                            </div>
                        
                </div>
                </div>
                </div>

               



    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
           
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Cateogry</h5>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this product?</p>
                        <input type="hidden" name="delete_id" id="delete_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="delete_category" name="delete_category" class="btn btn-danger">Delete Category</button>
                    </div>
                </div>
        
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?=ASSETS?>js/category.js"></script>
    <script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
