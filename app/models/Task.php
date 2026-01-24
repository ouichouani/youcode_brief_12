<?php 


namespace App\Models ;

use App\Core\Database;
use Exception;

class Task {


    public static function getAll(): array
    {

        $connection = Database::getInstance()->getConnection() ;
        $statement = $connection->prepare("UPDATE tasks SET chicked = 1 WHERE id = ?");
        $statement->execute() ;
        return $statement->fetch(\PDO::FETCH_ASSOC) ;

    }



    public static function getById(int $id): array
    {

        $connection = Database::getInstance()->getConnection() ;
        $statement = $connection->prepare("UPDATE tasks SET chicked = 1 WHERE id = ?");
        $statement->execute([$id]) ;
        return $statement->fetch(\PDO::FETCH_ASSOC) ;

    }

    public static function markAsDone(int $id): bool
    {

        if(self::getById($id)) throw new \Exception('task doesn\'t exist' ) ;

        $connection = Database::getInstance()->getConnection() ;
        $statement = $connection->prepare("UPDATE tasks SET chicked = 1 WHERE id = ?");
        $statement->execute([$id]) ;
        if($statement) return true ;
        return false ;
        
    }
}