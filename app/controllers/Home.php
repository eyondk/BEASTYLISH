<?php

/**
 *  home class
 */

class Home extends Controller

{  
    
    public function index()
    {   
        $product = new UserProduct();

      
        $products = $product->get_latest_products();
        
        $this->view('customer/home', ['products' => $products]);
    }   
}