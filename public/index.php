<?php

require_once __DIR__ . '/../vendor/autoload.php';



use App\core\Database;

    $db = Database::getInstance();
    $db->getConnection();
    echo "hello world";