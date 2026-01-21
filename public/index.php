<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\core\Router ;
use App\core\Database;
// use app\controller\

use App\controllers\AuthController;

session_start();

$db = Database::getInstance();
$db->getConnection();

// $router->dispatch();
// use App\core\Database;

    // $db = Database::getInstance();
    // $db->getConnection();
    // echo "hello world";
    // phpinfo();
//     $db = Database::getInstance();
//     $db->getConnection();
//     echo "hello world";echo "hello world";


$router = new Router() ;

// $router->get('/' , "dashboard/dashboard");

$router->get('/', [AuthController::class , "showLogin"]);
$router->get('/login', [AuthController::class , "showLogin"]);
$router->post('/login',[AuthController::class , "login"]);
$router->get('/register',[AuthController::class , "showRegister"]);
$router->post('/register',[AuthController::class , "register"]);
$router->get('/logout',[AuthController::class , "logout"]);
$router->get('/forgot-password',[AuthController::class , "showForgotPassword"]);
$router->post('/forgot-password',[AuthController::class , "forgotPassword"]);

// ha kifach tst3mlo router 
// $router->get( path , [classname::class , 'method' ]) ;
// $router->get( path , func(){ ... }) ;

$router->resolve() ;
