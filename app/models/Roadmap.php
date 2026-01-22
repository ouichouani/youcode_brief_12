<?php


namespace App\Models;

use App\Core\Database;


class Roadmap
{

    public static function getRoadmap(int $userId): array
    {
        $connection = Database::getInstance()->getConnection();
        $request  = "SELECT * FROM roadmap WHERE user_id = ? AND passed = FALSE ORDER BY created_at LIMIT 1";
        $stmt = $connection->prepare($request);
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function generateRoadmap(){
        //...
    }

}
