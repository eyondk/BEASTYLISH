<?php
spl_autoload_register(function($classname){
    require $filname = "../app/models/".ucfirst($classname).".php";
});

require 'config.php';
require 'function.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';
