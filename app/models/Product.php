<?php

/**
 * User class
 */

class Product
{

    use Model;

    protected $table = 'products';

    protected $allowedColumns = [

      'prod_name',
      'prod_description',
      'prod_price',
      'prod_stock',
      'prod_image',
      'categ_id'
    ];

   


    // Method to fetch all products from the database
    public function get_products() {
      try {
          $conn = $this->connect();
          $stmt = $conn->prepare("SELECT * FROM products");
          $stmt->execute();
          $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $products;
      } catch (PDOException $e) {
          // Log the error or handle it as needed
          error_log("Database error: " . $e->getMessage());
          return [];
      }
    }
      public function search_products($keyword){
        try {
          $conn = $this->connect();
          $stmt = $conn->prepare("SELECT * FROM products WHERE LOWER(prod_name) LIKE LOWER(:keyword)");
          $stmt->execute(['keyword' => '%' . strtolower($keyword) . '%']);
          $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

          return $products;
        } catch (PDOException $e) {
            // Handle any database errors here
            error_log('Error searching products: ' . $e->getMessage());
            return [];
        }
    }
  
          
}
