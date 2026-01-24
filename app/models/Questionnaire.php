<?php


namespace App\Models;

use App\core\Database;
use PDO;

class Questionnaire
{
    public static function getAll(): array
    {
        $connection = Database::getInstance()->getConnection();
        $request = "SELECT * from question ORDER BY id ASC";
        $stmt =  $connection->prepare($request);
        $stmt->execute() ;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
}
