<?php 
if($_SERVER['SERVER_NAME'] == 'localhost'){


   


    define('DB_HOST', 'localhost');
    define('DB_NAME', 'beastylish_db');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', 'yron312');

    $path = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] .$_SERVER['PHP_SELF'];
    $path = str_replace("index.php", "", $path);

    define('ROOT', $path);
    define('ASSETS', $path. "assets/");

}
else{
    define('ROOT', 'http://localhost/mvc/public');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'IM');
    define('DB_USER', 'postgres');
    
}

