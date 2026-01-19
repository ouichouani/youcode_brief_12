<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;



$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$db_credentials = [
    'host' => $_ENV['DATABASE_HOST'],
    'username' => $_ENV['DATABASE_USERNAME'],
    'password' => $_ENV['DATABASE_PASSWORD'],
    'dbname' => $_ENV['DATABASE_DBNAME']
];

return $db_credentials;