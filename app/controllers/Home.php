<?php

/**
 *  home class
 */

class Home extends Controller

{  
    
    public function index()
    {   
        $product = new Product();

      
        $products = $product->get_latest_products();
        
        $this->view('home', ['products' => $products]);
    }   
}




