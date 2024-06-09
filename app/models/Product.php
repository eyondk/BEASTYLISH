<?php

class Product
{
    use Model;

    protected $table = 'products';

    protected $allowedColumns = [
        'prod_name',
        'prod_description',
        'prod_price',
        'prod_stock',
        'prod_sizes',
        'prod_color',
        'categ_id'
    ];

    public function get_products()
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                SELECT p.*, pi.image_path, c.categ_name
                FROM products p 
                LEFT JOIN product_images pi ON p.prod_id = pi.prod_id 
                LEFT JOIN category c ON p.categ_id = c.categ_id
                ORDER BY p.prod_id DESC
            ");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $products;
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function search_products($keyword)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                SELECT p.*, pi.image_path, c.categ_name
                FROM products p 
                LEFT JOIN product_images pi ON p.prod_id = pi.prod_id 
                LEFT JOIN category c ON p.categ_id = c.categ_id
                WHERE LOWER(p.prod_name) LIKE LOWER(:keyword)
            ");
            $stmt->execute(['keyword' => '%' . strtolower($keyword) . '%']);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            // Handle any database errors here
            error_log('Error searching products: ' . $e->getMessage());
            return [];
        }
    }

    public function insert_product_with_image($productData, $imageData)
    {
        try {
            $conn = $this->connect();
            $conn->beginTransaction();
    
            // Step 1: Check if category exists, if not, insert it
            $categorySql = "SELECT categ_id FROM category WHERE categ_name = :categ_name";
            $categoryStmt = $conn->prepare($categorySql);
            $categoryStmt->bindParam(':categ_name', $productData['categ_name'], PDO::PARAM_STR);
            $categoryStmt->execute();
            $categoryResult = $categoryStmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$categoryResult) {
                // Category does not exist, insert it
                $insertCategorySql = "INSERT INTO category (categ_name) VALUES (:categ_name)";
                $insertCategoryStmt = $conn->prepare($insertCategorySql);
                $insertCategoryStmt->bindParam(':categ_name', $productData['categ_name'], PDO::PARAM_STR);
                $insertCategoryStmt->execute();
                $productData['categ_id'] = $conn->lastInsertId();
            } else {
                // Category exists, use its ID
                $productData['categ_id'] = $categoryResult['categ_id'];
            }
    
            // Step 2: Insert product data
            $productSql = "INSERT INTO products (prod_name, prod_description, prod_price, prod_stock, prod_sizes, prod_color, categ_id) 
                            VALUES (:prod_name, :prod_description, :prod_price, :prod_stock, :prod_sizes, :prod_color, :categ_id)";
            $productStmt = $conn->prepare($productSql);
            $productStmt->execute([
                ':prod_name' => $productData['prod_name'],
                ':prod_description' => $productData['prod_description'],
                ':prod_price' => $productData['prod_price'],
                ':prod_stock' => $productData['prod_stock'],
                ':prod_sizes' => $productData['prod_sizes'],
                ':prod_color' => $productData['prod_color'],
                ':categ_id' => $productData['categ_id']
            ]);
            $prodId = $conn->lastInsertId();
    
            // Step 3: Insert image data
            $imageSql = "INSERT INTO product_images (prod_id, image_path) VALUES (:prod_id, :image_path)";
            $imageStmt = $conn->prepare($imageSql);
            $imageStmt->execute([
                ':prod_id' => $prodId,
                ':image_path' => $imageData['image_path']
            ]);
    
            // Step 4: Commit transaction
            $conn->commit();
            return true;
        } catch (PDOException $e) {
            // Step 5: Roll back transaction on error
            $conn->rollBack();
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    
    public function get_products_by_category($categ_name)
    {
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("
                SELECT p.*, pi.image_path, c.categ_name
                FROM products p 
                LEFT JOIN product_images pi ON p.prod_id = pi.prod_id 
                LEFT JOIN category c ON p.categ_id = c.categ_id
                WHERE c.categ_name = :categ_name
            ");
            $stmt->bindParam(':categ_name', $categ_name, PDO::PARAM_STR);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $total = $stmt->rowCount();
            if ($total > 0) {
                return $products;
            } else {
                return [];
            }
        } catch (PDOException $e) {
            // Handle any database errors here
            error_log("Error fetching products by category name: " . $e->getMessage());
            return [];
        }
    }
}




    // Method to fetch all products from the database
    // public function get_products() {
    //   try {
    //       $conn = $this->connect();
    //       $stmt = $conn->prepare("SELECT * FROM products ORDER BY prod_id DESC");
    //       $stmt->execute();
    //       $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //       return $products;
    //   } catch (PDOException $e) {
    //       // Log the error or handle it as needed
    //       error_log("Database error: " . $e->getMessage());
    //       return [];
    //   }
    // }
//     public function get_products() {
//       try {
//           $conn = $this->connect();
//           $stmt = $conn->prepare("
//               SELECT p.*, pi.image_path 
//               FROM products p 
//               LEFT JOIN product_images pi ON p.prod_id = pi.prod_id 
//               ORDER BY p.prod_id DESC
//           ");
//           $stmt->execute();
//           $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
//           return $products;
//       } catch (PDOException $e) {
//           // Log the error or handle it as needed
//           error_log("Database error: " . $e->getMessage());
//           return [];
//       }
//   }
  


//   public function search_products($keyword){
//     try {
//         $conn = $this->connect();
//         $stmt = $conn->prepare("
//             SELECT p.*, pi.image_path 
//             FROM products p 
//             LEFT JOIN product_images pi ON p.prod_id = pi.prod_id 
//             WHERE LOWER(p.prod_name) LIKE LOWER(:keyword)
//         ");
//         $stmt->execute(['keyword' => '%' . strtolower($keyword) . '%']);
//         $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         return $products;
//     } catch (PDOException $e) {
//         // Handle any database errors here
//         error_log('Error searching products: ' . $e->getMessage());
//         return [];
//     }
// }


//     public function insert_product_with_image($productData, $imageData) {
//       try {
//           $conn = $this->connect();
//           $conn->beginTransaction();

//           // Insert product data
//           $productSql = "INSERT INTO products (prod_name, prod_description, prod_price, prod_stock, prod_sizes, prod_color, categ_id) 
//                          VALUES (:prod_name, :prod_description, :prod_price, :prod_stock, :prod_sizes, :prod_color, :categ_id)";
//           $productStmt = $conn->prepare($productSql);
//           $productStmt->execute($productData);
//           $prodId = $conn->lastInsertId();

//           // Insert image data
//           $imageSql = "INSERT INTO product_images (prod_id, image_path) VALUES (:prod_id, :image_path)";
//           $imageStmt = $conn->prepare($imageSql);
//           $imageData['prod_id'] = $prodId;
//           $imageStmt->execute($imageData);

//           $conn->commit();
//           return true;
//       } catch (PDOException $e) {
//           $conn->rollBack();
//           error_log("Database error: " . $e->getMessage());
//           return false;
//       }
//     }

//     public function get_products_by_category($categ_id){
//         try {
//             $conn = $this->connect();
//             $stmt = $conn->prepare("
//                 SELECT p.*, pi.image_path 
//                 FROM products p 
//                 LEFT JOIN product_images pi ON p.prod_id = pi.prod_id 
//                 WHERE p.categ_id = :categ_id
//             ");
//             $stmt->bindParam(':categ_id', $categ_id, PDO::PARAM_INT);
//             $stmt->execute();
//             $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
//             $total = $stmt->rowCount();
//             if ($total > 0) {
//                 return $products;
//             } else {
//                 return false;
//             }
//         } catch (PDOException $e) {
//             // Handle any database errors here
//             error_log("Error fetching products by category: " . $e->getMessage());
//             return false;
//         }
//     }
    
