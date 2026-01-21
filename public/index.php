<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Router;
use App\core\Database;
// use app\controller\

// echo '<pre>' ;
// print_r($_SERVER) ;
// echo '</pre>' ;

// use App\core\Database;

$db = Database::getInstance();
$db->getConnection();
echo "hello world";
phpinfo();
//     $db = Database::getInstance();
//     $db->getConnection();
//     echo "hello world";echo "hello world";


$router = new Router();

$router->get('/', "dashboard/dashboard");
$router->get('/questionnaire', [App\controllers\QuestionnaireController::class, 'askQuest']);
$router->post('/questionnaire', [App\controllers\QuestionnaireController::class, 'captureResponse']);
$router->get('/roadmap/generate', [App\controllers\QuestionnaireController::class, 'generateRoadmap']);
$router->get('/roadmap/show', [App\controllers\RoadmapController::class, 'renderRoadmap']);

$router->resolve();
