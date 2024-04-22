<?php 
if($_SERVER['SERVER_NAME'] == 'localhost'){


    
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'IM');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', 'yron312');
    define('ROOT', 'http://localhost/mvc/public');

}
else{
    define('ROOT', 'http://localhost/mvc/public');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'IM');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', 'yron312');
 
}

