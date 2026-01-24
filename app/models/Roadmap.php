<?php


namespace App\Models;
use App\Core\Database;


class Roadmap
{
    
    public static function getRoadmap(int $userId): array
    {
        $connection = Database::getInstance()->getConnection();
        $request = "SELECT * FROM roadmaps WHERE user_id = ? ORDER BY created_at DESC LIMIT 1 "; 
        $stmt = $connection->prepare($request);
        $stmt->execute([$userId]);
        $Roadmap = $stmt->fetch(\PDO::FETCH_ASSOC) ;
        if($Roadmap) return $Roadmap;
        return [] ;
       
    }

    public static function saveRoadmap($userId, $content): bool
    {
        $connection = Database::getInstance()->getConnection();
        $request = "INSERT INTO roadmaps (user_id, content) VALUES (?, ?)";
        $stmt = $connection->prepare($request);
        return $stmt->execute([$userId, $content]);
    }
}
