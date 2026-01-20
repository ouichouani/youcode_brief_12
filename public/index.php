<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Router ;
// use app\controller\

// echo '<pre>' ;
// print_r($_SERVER) ;
// echo '</pre>' ;

// use App\core\Database;

//     $db = Database::getInstance();
//     $db->getConnection();
//     echo "hello world";echo "hello world";


$router = new Router() ;

$router->get('/' , "dashboard/dashboard") ;




$router->resolve() ;