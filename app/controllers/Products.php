<?php

class Products extends Controller
{

    public function index()
    {
      
        
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
           
        

        $products = $prod->getProducts();
        $data['products'] =$products;
        $this->view('admin/Products', $data);
    }

}