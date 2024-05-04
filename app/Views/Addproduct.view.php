<?php
$connection = new Database;
$model = new Model;
$conn = $connection -> connect();

if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_description = $_POST['product_description'];
    $product_stocks = $_POST['product_stocks'];
    $product_category = $_POST['product_category'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/'.$product_image;

    if(empty($product_name) || empty($product_price) || empty($product_description) || empty($product_stocks) || empty($product_category) || empty($product_image)){
        $message[] = 'Please fill out all fields';
    } else {
        try {
            // Prepare the SQL statement with placeholders
            $insert= "INSERT INTO products(prod_name, prod_price, prod_description, prod_stock, categ_id, prod_image) VALUES(:name, :price, :description, :stocks, :category_id, :image)";
            $stmt = $conn ->prepare($insert);

            // Bind parameters
            $stmt->bindParam(':name', $product_name);
            $stmt->bindParam(':price', $product_price);
            $stmt->bindParam(':description', $product_description);
            $stmt->bindParam(':stocks', $product_stocks);
            $stmt->bindParam(':category_id', $product_category);
            $stmt->bindParam(':image', $product_image);

            // Execute the query
            $stmt->execute();

            // Move uploaded file
            // move_uploaded_file($product_image_tmp_name, $product_image_folder);

            $message[] = 'New product added successfully';
        } catch(PDOException $e) {
            $message[] = 'Could not add the product: ' . $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/products.css">
    <title>Add Product</title>
</head>
<body>
    <?php include 'admin_header.php';?>
    <section class="home">
        <div class="text">PRODUCTS</div>
        <hr id = "line" />
    <div class="container">
    <div class="admin-product-form-container">

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <h3>add a new product</h3>
        <input type="text" placeholder="Enter Product Name" name="product_name" class="box">
        <input type="number" placeholder="Price" name="product_price" class="box">
        <input type="text" placeholder="Description" name="product_description" class="box">
        <input type="number" placeholder="Stocks" name="product_stocks" class="box">
        <select  name="product_category" class="box">
            <option value="1">Shirt</option>
            <option value="2">Pants</option>
            <option value="3">Boquet</option>
    
        </select>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
        <input type="submit" class="add-btn" name="add_product" value="add product">
        <a href="<?=ROOT?>Products"  class="add-btn">Go back</a>
    </form>

    </div>
</section>
</body>
</html>

