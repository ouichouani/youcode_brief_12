<?php

namespace App\Models;

use App\Core\Database;
use App\Models\AI;
use DateTime;

class Plan
{

    public static function create(int $user_id ,array $roadmap  )
    {

        $connection = Database::getInstance()->getConnection();
        $plan_content = AI::generatePlan($roadmap['content'], new DateTime($roadmap['created_at']));
        $stmt = $connection->prepare("INSERT INTO plan (user_id, roadmap_id,content , ai_notes) VALUES (? ,?, ?, ?)");       
        $stmt->execute([$user_id, $roadmap['id'], $plan_content ,'']);
        return ; 
    }

    public static function getALL(int $user_id, int $roadmap_id): array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM plan WHERE user_id = ? AND roadmap_id = ? ");
        $stmt->execute([$user_id, $roadmap_id]);
        $plans = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $plans;
    }

    public static function getLast(int $user_id, int $roadmap_id): array
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM plan WHERE user_id = ? AND roadmap_id = ? ORDER BY created_at DESC  LIMIT 1 ");
        $stmt->execute([$user_id, $roadmap_id]);
        $plan = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $plan;
    }

    public static function UpdateProgress(array $plan)
    {
        // completion_percentage ...
    }
}
