<?php

class Shop extends Controller
{  
    public function index()
    {
        $product = new Product();
        $is_search = false;
        $search_results = [];

        // $productData = [
        //     'prod_name' => 'Bracelet Test 2',
        //     'prod_description' => 'Test Product',
        //     'prod_price' => 300,
        //     'prod_stock' => 50,
        //     'prod_sizes' => '',
        //     'prod_color' => '',
        //     'categ_name' => 'BRACELET'  // Category name as per your categories table
        // ];
        
        // $imageData = [
        //     'image_path' => ROOT . '/assets/images/bracelet1.jpg'
        // ];
        // show($productData);
        // show($imageData);
        // show($product);
        // // Attempt to insert product with image
        // $inserted = $product->insert_product_with_image($productData, $imageData);
     

        // if ($inserted) {
        //     echo "Product inserted successfully.";
        // } else {
        //     echo "Failed to insert product.";
        // }

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $keyword = $_GET['search'];
            $is_search = true;
            $search_results = $product->search_products($keyword);
        } elseif (isset($_GET['categ_name'])) {
            $categ_name = $_GET['categ_name'];
            $products = $product->get_products_by_category($categ_name);
        } else {
            $products = $product->get_products();
        }
       

        $this->view('shop', [
            'is_search' => $is_search,
            'search_results' => $search_results,
            'products' => $products ?? []
        ]);
    }
}
