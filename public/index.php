<?php

require_once __DIR__ . '/../vendor/autoload.php';



use App\core\Database;
use App\core\router;
// use App\core\controller;
session_start();

$db = Database::getInstance();
$db->getConnection();
//echo "hello world";

$router = new Router();

$router->get('/', 'AuthController@showLogin');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@showForgotPassword');
$router->post('/forgot-password', 'AuthController@forgotPassword');

$router->dispatch();