<?php

/**
 *  home class
 */

class Home extends Controller

{  
    
    public function index()
    {   
        $product = new Product();

      
        $products = $product->get_products();
        
        $this->view('home', ['products' => $products]);
    }   
}




