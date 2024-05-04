<?php

class Home extends Controller
{

    public function index()
    {

       

        echo "This is the home controller";
        $this->view('home');
    }

}

