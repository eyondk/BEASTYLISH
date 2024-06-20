<?php 
class Categ extends Model
{
    protected $table = 'category';
//CATEGORY FUNCTION
public function insertCategory($data) {
    try {
        
        // Insert product details into the products table using named placeholders
        $stmt = $this->conn->prepare("INSERT INTO category (categ_name) VALUES (:categ_name)");

        $stmt->bindParam(':categ_name', $data['categ_name']);
      
        $stmt->execute();

        $productId = $this->conn->lastInsertId();


        return ['success' => true, 'messages' => ['Category added successfully']];
    } catch (PDOException $e) {
        return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
    }
}

public function hasProducts($categ_id) {
    $sql = "SELECT COUNT(*) as count FROM products WHERE categ_id = :categ_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':categ_id', $categ_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] > 0;
}



public function deleteCategory($data) {
    try {
        // Check if the category has associated products
        $hasProducts = $this->hasProducts($data['categ_id']);
        if ($hasProducts) {
            return ['success' => false, 'messages' => ['This category cannot be deleted because there are associated products.']];
        }

        // Proceed to delete the category
        $sql = "DELETE FROM category WHERE categ_id = :categ_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':categ_id', $data['categ_id']);
        $stmt->execute();

        return ['success' => true, 'messages' => ['Category deleted successfully']];
    } catch (PDOException $e) {
        return ['success' => false, 'messages' => ['Error: ' . $e->getMessage()]];
    }
}

public function getCategory(){
        
        $sql = "SELECT * FROM category";
   
    

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
}
}