<?php
require_once __DIR__ . '/../vendor/autoload.php';

define('BASE_URL', '/'); 

use App\core\Router ;
use App\core\Database;

use App\controllers\AuthController;
use App\controllers\QuestionnaireController;

session_start();

$db = Database::getInstance();
// phpinfo();
// echo "hello world";
$db->getConnection();

$router = new Router();

// $router->dispatch();
// use App\core\Database;

    // $db = Database::getInstance();
    // $db->getConnection();
    // echo "hello world";
    // phpinfo();
//     $db = Database::getInstance();
//     $db->getConnection();
//     echo "hello world";echo "hello world";



$router->get('/' , "dashboard/dashboard");

$router->get('/', [AuthController::class , "showLogin"]);
$router->get('/login', [AuthController::class , "showLogin"]);
$router->post('/login',[AuthController::class , "login"]);
$router->get('/register',[AuthController::class , "showRegister"]);
$router->post('/register',[AuthController::class , "register"]);
$router->get('/logout',[AuthController::class , "logout"]);
$router->get('/forgot-password',[AuthController::class , "showForgotPassword"]);
$router->post('/forgot-password',[AuthController::class , "forgotPassword"]);
//just for testing
$router->get('/signup',[QuestionnaireController::class , "askQuest"]);
$router->get('/questionnaire',[QuestionnaireController::class , "captureResponse"]);

// // ha kifach tst3mlo router 
// $router->get( path , [classname::class , 'method' ]) ;
// $router->get( path , func(){ ... }) ;

$router->resolve() ;
