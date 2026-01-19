<?php


namespace App\core;



use PDO;
use PDOException;


class Database
{
    private static PDO $conn;
    private static Database $instance;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/connexion.php';
        try {


        
            $dsn = "pgsql:host={$config['host']};dbname={$config['dbname']}";
            self::$conn = new PDO($dsn, $config['username'], $config['password']);

            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $pe) {
            die("Connection error due to this =>  " . $pe->getMessage());
        }
    }


    public static function getInstance(): Database
    {
        if (!isset(self::$conn)) {
            self::$instance = new self();
        }
        return self::$instance;
    }



    public function getConnection()
    {
        return self::$conn;
    }
}