<?php


if($_SERVER['SERVER_NAME'] == 'localhost')
{
    /** database config **/
    define('DB_NAME', 'CC214A');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', '');
    //define('DBDRIVER', ''); /** incase u want to switch db like postgre**/

    define('ROOT', 'http://localhost/mvc/public');
}
else
{

    /** database config **/
    define('DB_NAME', 'CC214A');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', 'addyimba123desu');
    //define('DBDRIVER', '');
    
    #this is what you'll do if you put ur website online just change the website name.
    define('ROOT', 'https://www.yourwebsite.com');
}

define('APP_NAME', "My Website");
define('APP_DESC', "Best website on the planet");

/** true means show errors otherwise false. (change it to false when you go to live server to not show errors) **/
define('DEBUG', true);
