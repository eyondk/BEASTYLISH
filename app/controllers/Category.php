<?php

class Category extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] === null) {
            // Redirect to the login page
            header('Location: home/login'); // Adjust the path as needed for your application
            exit();
        }
        $categ = new Categ();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = $_POST;

            if (isset($data['action'])) {
                if ($data['action'] == 'insert') {
                    $result = $categ->insertCategory($data);
                } elseif ($data['action'] == 'delete') {
                    $result = $categ->deleteCategory($data);
                } elseif ($data['action'] == 'checkForProducts') {
                    $hasProducts = $categ->hasProducts($data['categ_id']);
                    echo json_encode(['hasProducts' => $hasProducts]);
                    exit;
                } else {
                    $result = ['success' => false, 'messages' => 'Invalid action.'];
                }

                echo json_encode(['status' => $result['success'] ? 'success' : 'error', 'message' => $result['messages']]);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Action not specified.']);
                exit;
            }
        }

        $categories = $categ->getCategory();
        $data['categ'] = $categories;
        $this->view('admin/Category', $data);
    }
}
