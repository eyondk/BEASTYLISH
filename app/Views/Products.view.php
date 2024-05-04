<?php
$connection = new Database;
$conn = $connection -> connect();
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE prod_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('location:Products.view.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/products.css">
    <title>Document</title>
</head>
<body>
    <?php include 'admin_header.php';?>

    <section class="home">
    <div class = "container">
    <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>product image</th>
            <th>product name</th>
            <th>product price</th>
            <th>product Description</th>
            <th>product stocks</th>
            <th>product Category</th>
            <th>action</th>
         </tr>
         </thead>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['prod_name']; ?></td>
            <td>$<?php echo $row['prod_price']; ?>/-</td>
            <td><?php echo $row['prod_description']; ?></td>
            <td><?php echo $row['prod_stock']; ?></td>
            <td><?php echo $row['categ_id']; ?></td>
            <td>
                <a href="<?=ROOT?>AddProduct?edit=<?php echo $row['prod_id']; ?>" class="btns"> <i class="fas fa-edit"></i> edit </a>
                <a href="<?=ROOT?>Products/?delete=<?php echo $row['prod_id']; ?>" class="btns"> <i class="fas fa-trash"></i> delete </a>
            </td>
        </tr>
    <?php } ?>

      </table>
   </div>
</div>
<a href="<?=ROOT?>AddProduct" class="btns">Add Product</a>
</div>

</section>
</body>
</html>