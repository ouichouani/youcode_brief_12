<?php

namespace App\Models;

use App\Core\Database;
use App\Models\User;


class Plan
{

    public static function create(int $userId, int $roadmapId, string $content)
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("INSERT INTO plan (user_id, roadmap_id, content) VALUES (?, ?, ?)");
        if ($stmt->execute([$userId, $roadmapId, $content])) {
            return $connection->lastInsertId();
        }
        return false;
    }

    public static function getPlan(int $user_id, int $roadmap_id): array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM plan WHERE user_id = ? AND roadmap_id = ? ");
        $stmt->execute([$user_id, $roadmap_id]);
        $plan = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($plan)
            return $plan;
        return [];
    }

    public static function UpdateProgress(array $plan)
    {
        // completion_percentage ...
    }


}