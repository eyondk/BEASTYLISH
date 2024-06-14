<?php

class Category extends Controller
{
    public function index()
    {
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
        $this->view('Category', $data);
    }
}
