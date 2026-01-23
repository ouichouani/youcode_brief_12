<?php

namespace App\Models;

use App\Core\Database;
use App\Models\User;


class Plan {

    public function create(string $plan){
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("INSERT INTO plan (fullname, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$plan]);    
    }

    public static function getPlan(int $user_id ,int $roadmap_id): array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM plan WHERE user_id = ? AND roadmap_id = ? ") ;
        $stmt->execute([$user_id , $roadmap_id]);    
        $plan = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($plan) return $plan ;
        return [] ;
    }

    public static function UpdateProgress(array $plan){
        // completion_percentage ...
    }


}