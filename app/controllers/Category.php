<?php

class Category extends Controller
{

    public function index()
    {
      
        
        $categ = new Categ;
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;
            print_r($data);
          

            if (isset($data['action'])) {
                if ($data['action'] == 'insert') {
                    $result = $categ->insertCategory($data);
                } elseif ($data['action'] == 'delete') {
                    $result = $categ->deleteCategory($data);
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
           
        

        $categories = $categ->getCategory();
        $data['categ'] =$categories;
        $this->view('Category', $data);
    }

}