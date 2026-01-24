<?php

namespace App\Models;

use App\Core\Database;
// use App\Models\User;


class Skill{

    public static function getAll(int $user_id , int $roadmap_id){
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM skills WHERE  user_id = ? AND roadmap_id = ? ") ;
        $stmt->execute([$user_id , $roadmap_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}