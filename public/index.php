<?php
require_once __DIR__ . '/../vendor/autoload.php';

define('BASE_URL', $_SERVER['SCRIPT_NAME']);

$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
// var_dump($scriptDir);
// exit;
if ($scriptDir === '/' || $scriptDir === '/public') {
    define('APP_ROOT', '');
} else {

    if (basename($scriptDir) === 'public') {
        define('APP_ROOT', dirname($scriptDir));
    } else {
        define('APP_ROOT', $scriptDir);
    }
}

use App\core\Router;
use App\core\Database;
use App\Controllers\AuthController;
use App\Controllers\Dashboard;
use App\Controllers\QuestionnaireController;
use App\Controllers\OpportunityController;
use App\Controllers\HomeController;
use App\Controllers\RoadmapController;
use App\Controllers\TasksController;

use App\Controllers\CommunityController;
use App\Controllers\ProfileController;

session_start();

$db = Database::getInstance();
$db->getConnection();

$router = new Router();

$router->get('/', [HomeController::class, "index"]);
$router->get('/dashboard', [Dashboard::class, "show"]);

$router->get('/login', [AuthController::class, "showLogin"]);
$router->post('/login', [AuthController::class, "login"]);

$router->get('/signup', [AuthController::class, "showRegister"]);
$router->get('/register', [AuthController::class, "showRegister"]);
$router->post('/register', [AuthController::class, "register"]);

$router->get('/logout', [AuthController::class, "logout"]);

$router->get('/forgot-password', [AuthController::class, "showForgotPassword"]);
$router->post('/forgot-password', [AuthController::class, "forgotPassword"]);
$router->get('/reset-password', [AuthController::class, "showResetPassword"]);
$router->post('/reset-password', [AuthController::class, "resetPassword"]);

// Questionnaire routes
$router->get('/questionnaire', [QuestionnaireController::class, "askQuest"]);
$router->post('/questionnaire', [QuestionnaireController::class, "captureResponse"]);

$router->get('/plan', [Dashboard::class, "createPlan"]);

// Roadmap routes
$router->get('/roadmap/generate', [QuestionnaireController::class, "generateRoadmap"]);
$router->get('/roadmap/show', [RoadmapController::class, "renderRoadmap"]);

// Task routes
$router->get('/tasks', [TasksController::class, "index"]);
$router->post('/markAsDone', [TasksController::class, "markAsDone"]);

// Community routes
$router->get('/community', [CommunityController::class, "index"]);
$router->post('/community/post', [CommunityController::class, "createPost"]);
$router->post('/community/comment', [CommunityController::class, "addComment"]);
$router->post('/community/like', [CommunityController::class, "toggleLike"]);

// Profile routes
$router->get('/profile', [ProfileController::class, "index"]);
$router->post('/profile/update', [ProfileController::class, "update"]);
$router->post('/profile/password', [ProfileController::class, "changePassword"]);

// Placeholder routes
$router->get('/opportunities', [OpportunityController::class, "showAll"]);
$router->get('/opportinity', [OpportunityController::class, "show"]);
$router->get('/skills', [HomeController::class, "skills"]);

$router->resolve();
