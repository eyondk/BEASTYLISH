<?php

/**
 *  shop class
 */

class Shop extends Controller

{  
    
    public function index()
    {
        $product = new Product();
        $is_search = false;
        $search_results = [];
        
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $keyword = $_GET['search'];
            $is_search = true;
            $search_results = $product->search_products($keyword);
        } else {
            $products = $product->get_products();
        }

        $this->view('shop', [
            'is_search' => $is_search,
            'search_results' => $search_results,
            'products' => $products ?? []
        ]);
    }

    // public function index()
    // {   
    //     $product = new Product();
    //     $search_results = [];
    //     $is_search = false;

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    //         $keyword = trim($_POST['search']);
    //         if (!empty($keyword)) {
    //             $search_results = $book->search_books($keyword);
    //             $is_search = true;
                
    //         }
    //     }
    
        
    //     // $arr = [
    //     //                 'prod_name' => 'Product Test 3',
    //     //                 'prod_description' => 'Test Product',
    //     //                 'prod_price' => 777,
    //     //                 'prod_stock' => 70,
    //     //                 'prod_image' => ROOT . '/assets/images/manga-bluelock.jpg',
    //     //                 'categ_id' => 5
    //     //         ];
    //     //     $product->insert($arr);

    //     // // Fetch products from the database
    //     $products = $product->get_products();
    

   
    //     // // Debugging: Check if products are fetched

    //     // error_log(print_r($products, true));
    
    //     // Pass the products to the view
    //     $this->view('shop', ['products' => $products]);
    // }
}




