<?php

class Products extends Controller
{

    public function index()
    {
      
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: login'); // Adjust the path as needed for your application
            exit();
        }
        
        $prod = new Product;
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;
            $files = $_FILES;
           

            if (isset($data['action'])) {
                if ($data['action'] == 'insert') {
                    $result = $prod->insertProduct($data, $files);
                } elseif ($data['action'] == 'update') {
                    $result = $prod->updateProduct($data, $files);
                } elseif ($data['action'] == 'delete') {
                    $result = $prod->deleteProduct($data);
                }else {
                    $result = ['success' => false, 'messages' => 'Invalid action.'];
                }
    
                if ($result['success']) {
                    echo json_encode(['status' => 'success', 'message' => $result['messages']]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $result['messages']]);
                }
                exit; // Prevent further execution
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Action not specified.']);
                exit;
            }
        }
           
        
        $categories = $prod->getCategories();
        $products = $prod->getProducts();
        $data['products'] =$products;
        $data['category'] =$categories;
        $this->view('admin/Products', $data);
    }

}