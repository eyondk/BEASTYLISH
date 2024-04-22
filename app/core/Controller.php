<?php

class Controller
{

    public function view($name){
        $filename = "../app/Views/".$name.".view.php";
        if(file_exists($filename)){
            require $filename;
        }else{
            $filename = "../app/Views/404.view.php";
            require $filename;
        }
    }
}