<?php

/**
 *  home class
 */

class Home extends Controller

{  
    
    public function index()
    {   
        
        $model = new Model;
        $model -> test();
        
        echo "This is the home controller";
        $this->view('home');
        
        $this->view('home');
    }   
}




