<?php
require_once __DIR__ . '/../vendor/autoload.php';

define('BASE_URL', '/');

use App\core\Router;
use App\core\Database;
use App\controllers\AuthController;
use App\controllers\QuestionnaireController;
use App\controllers\OpportunityController;



session_start();

use App\controllers\RoadmapController;

$db = Database::getInstance();
$db->getConnection();

$router = new Router();

$router->get('/', [AuthController::class, "showRegister"]);
$router->get('/dashboard', "dashboard/dashboard");
$router->get('/login', [AuthController::class, "showLogin"]);
$router->post('/login', [AuthController::class, "login"]);
$router->get('/register', [AuthController::class, "showRegister"]);
$router->post('/register', [AuthController::class, "register"]);
$router->get('/logout', [AuthController::class, "logout"]);
$router->get('/forgot-password', [AuthController::class, "showForgotPassword"]);
$router->post('/forgot-password', [AuthController::class, "forgotPassword"]);


// Questionnaire routes
$router->get('/questionnaire', [QuestionnaireController::class, "askQuest"]);
$router->get('/signup', [QuestionnaireController::class, "askQuest"]);
$router->post('/questionnaire', [QuestionnaireController::class, "captureResponse"]);

// Signup alias (linked in layout)
$router->get('/signup', [AuthController::class, "showRegister"]);

// Roadmap routes
// $router->get('/roadmap/generate', [QuestionnaireController::class, "generateRoadmap"]);
// $router->get('/roadmap/show', [RoadmapController::class, "renderRoadmap"]);

// Placeholder routes for navigation links
// $router->get('/opportunities', [OpportunityController::class, "showAll"]);
// $router->get('/community', ...); 
// $router->get('/skills', ...);
// $router->get('/profile', ...);

$router->resolve();
