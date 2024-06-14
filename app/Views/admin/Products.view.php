

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/product.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Products</title>
</head>
<body>
    <?php include 'admin_header.php';?>
    <section class="home">
        <div class="text">PRODUCT</div>
                    <hr id = "line" />
                    <div class="container">
                        <div class="product-display">
                            <div class="searchbar">      
                                <input type="search" id="searchInput" class="searchInput" placeholder="Search for Products">
                                <button type="button" id="search-btn" class="search"><i class="fa-solid fa-magnifying-glass"></i></button> 
                            </div>
                            <div class="table-container">
                                <table id="productTable" class="product-display-table">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Product ID</th>
                                            <th>Product Name</th> 
                                            <th>Product Price</th>
                                            <th>Product Description</th>
                                            <th>Product Stocks</th>
                                            <th>Product Color</th>
                                            <th>Product Size</th>
                                            <th>Product Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($products as $product): ?>
                                        <tr>
                                            
                                            <td>

                                            <div class="image-gallery">
                                            <?php 
                                            // Check if 'image_paths' is not empty and split into an array
                                            if (!empty($product['image_paths'])):
                                                $imagePaths = explode(',', $product['image_paths']); // Split comma-separated paths
                                                foreach ($imagePaths as $path): ?>
                                                    <img src="../public/assets/images/<?= htmlspecialchars($path) ?>" height="100" alt="Product image">
                                                <?php endforeach;
                                            else: ?>
                                                <!-- Placeholder or default image if no images are available -->
                                                <img src="../public/assets/uploads/default.jpg" height="100" alt="No image available">
                                            <?php endif; ?>
                                        </div>
                                            </td>
                                            <td><?= $product['prod_id'] ?></td>
                                            <td><?= $product['prod_name'] ?></td>
                                            <td>&#8369; <?= number_format($product['prod_price'], 2) ?></td>
                                            <td><?= $product['prod_description'] ?></td>
                                            <td><?= $product['prod_stock'] ?></td>
                                            <td><?= $product['prod_color'] ?></td>
                                            <td><?= $product['prod_sizes'] ?></td>
                                            <td><?= $product['categ_name'] ?></td>
                                            <td>
                                                <button type="button" class="btns edit button-update" ><i class="fas fa-edit"></i> Edit</button>
                                                <button type="button"   class="btns delete button-delete"  ><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="totalproduct">
                                <?php $productCount = count($products);?>
                                <p class="tottext">Total Products: <?= $productCount ?></p>
                            </div>
                        </div>
                        <button type="button" class="btns add" id="addProduct" data-bs-toggle="modal" data-bs-target="#addModal">Add Product</button>
                      
                    </div>
                </section>
                    
                <div id="addModal" class="modal fade" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">

                <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modal-title">Add Product</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="message"></div>
                            
                                    <div id="imageFields">
                                        <div class="mb-3">
                                            <label for="product_image" class="form-label">Product Image</label>
                                            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image[]" class="form-control form-control-lg fs-6" id="product_image" required>
                                        </div>
                                    </div>
                                    <div id="moreImages"></div>
                                    
                                    <button type="button" class="btn btn-secondary" id="addImageBtn">Add Another Image</button>
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control form-control-lg fs-6" name="product_name" id="product_name" placeholder="Product Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_price" class="form-label">Price</label>
                                        <input type="text" class="form-control form-control-lg fs-6" name="product_price" id="product_price" placeholder="Price">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_stocks" class="form-label">Stocks</label>
                                        <input type="number" class="form-control form-control-lg fs-6" name="product_stocks" id="product_stocks" placeholder="Stocks">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_sizes" class="form-label">Sizes</label>
                                        <select class="form-select form-select-lg fs-6" name="product_sizes" id="product_sizes">
                                            <option value="S">Small</option>
                                            <option value="M">Medium</option>
                                            <option value="L">Large</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_colors" class="form-label">Colors</label>
                                        <select class="form-select form-select-lg fs-6" name="product_colors" id="product_colors">
                                            <option value="Red">Red</option>
                                            <option value="Blue">Blue</option>
                                            <option value="Green">Green</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_category" class="form-label">Category</label>
                                        <select class="form-select form-select-lg fs-6" name="product_category" id="product_category">
                                            <option value="1">Electronics</option>
                                            <option value="2">Clothing</option>
                                            <option value="3">Books</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Description</label>
                                        <textarea class="form-control form-control-lg fs-6" name="product_description" id="product_description" rows="3"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" id="add_product" name="add_product" class="btn btn-dark" value="add product">Add Product</button>
                            </div>
                        
                </div>
                </div>
                </div>

               


                 <!-- Update Modal -->
      
                 <div id="updateModal" class="modal fade" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">

                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" >
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modal-title">Update Product</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <div class="message"></div>
                                    <input type="hidden" name="update_id" id="update_id">
                                    <input type="hidden" name="old_image" id="old_image">
                                    <input type="hidden" name="current_stocks" id="current_stocks">
                                        <div id="imageFields">
                                            <div class="mb-3">
                                                <label for="product_image" class="form-label">Product Image (Up to 3 images)</label>
                                                <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image[]" class="form-control form-control-lg fs-6" id="update_image" required>
                                            </div>
                                        </div>
                                        <div id="moreImages"></div>
                                        
                                        <button type="button" class="btn btn-secondary" id="addImageBtn">Add Another Image</button>
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" class="form-control form-control-lg fs-6" name="update_name" id="update_name" placeholder="Product Name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_price" class="form-label">Price</label>
                                            <input type="text" class="form-control form-control-lg fs-6" name="update_price" id="update_price" placeholder="Price">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_stocks" class="form-label">Stocks</label>
                                            <input type="number" class="form-control form-control-lg fs-6" name="update_stocks" id="update_stocks" placeholder="Stocks">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_sizes" class="form-label">Sizes</label>
                                            <select class="form-select form-select-lg fs-6" name="update_sizes" id="update_sizes">
                                                <option value="S">Small</option>
                                                <option value="M">Medium</option>
                                                <option value="L">Large</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_colors" class="form-label">Colors</label>
                                            <select class="form-select form-select-lg fs-6" name="update_colors" id="update_colors">
                                                <option value="Red">Red</option>
                                                <option value="Blue">Blue</option>
                                                <option value="Green">Green</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_category" class="form-label">Category</label>
                                            <select class="form-select form-select-lg fs-6" name="update_category" id="update_category">
                                                <option value="1">Electronics</option>
                                                <option value="2">Clothing</option>
                                                <option value="3">Books</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_description" class="form-label">Description</label>
                                            <textarea class="form-control form-control-lg fs-6" name="update_description" id="update_description" rows="3"></textarea>
                                        </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" id="update_product" name="update_product" class="btn btn-dark" value="add product">Update Product</button>
                            </div>
        
                            </div>
                        </div>
                    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
           
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Product</h5>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this product?</p>
                        <input type="hidden" name="delete_id" id="delete_id">
                        <input type="hidden" name="prod_stocks" id="prod_stocks">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="delete_product" name="delete_product" class="btn btn-danger">Delete Product</button>
                    </div>
                </div>
        
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?=ASSETS?>js/product.js"></script>
    <script src="<?= ASSETS ?>js/admin.js"></script>
</body>
</html>
