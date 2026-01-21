<?php
require_once __DIR__ . '/../vendor/autoload.php';

<<<<<<< HEAD
use app\core\Router;
=======
use App\core\Router ;
>>>>>>> c447355cd395bb866bd8515fc4c361f310fae776
use App\core\Database;
// use app\controller\

use App\controllers\AuthController;

session_start();

$db = Database::getInstance();
$db->getConnection();

// $router->dispatch();
// use App\core\Database;

<<<<<<< HEAD
$db = Database::getInstance();
$db->getConnection();
echo "hello world";
phpinfo();
=======
    // $db = Database::getInstance();
    // $db->getConnection();
    // echo "hello world";
    // phpinfo();
>>>>>>> c447355cd395bb866bd8515fc4c361f310fae776
//     $db = Database::getInstance();
//     $db->getConnection();
//     echo "hello world";echo "hello world";


$router = new Router();

<<<<<<< HEAD
$router->get('/', "dashboard/dashboard");
$router->get('/questionnaire', [App\controllers\QuestionnaireController::class, 'askQuest']);
$router->post('/questionnaire', [App\controllers\QuestionnaireController::class, 'captureResponse']);
$router->get('/roadmap/generate', [App\controllers\QuestionnaireController::class, 'generateRoadmap']);
$router->get('/roadmap/show', [App\controllers\RoadmapController::class, 'renderRoadmap']);

$router->resolve();
=======
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
>>>>>>> c447355cd395bb866bd8515fc4c361f310fae776
