<?php

namespace App\Models;

use App\Core\Database;
use App\Models\User;
use App\Models\AI;
use App\Models\Roadmap;
use DateTime;

class Plan
{

    // id SERIAL PRIMARY KEY,
    // user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    // roadmap_id BIGINT REFERENCES roadmap (id) ON DELETE CASCADE,
    // content TEXT NOT NULL,
    // completion_percentage INT DEFAULT 0 CHECK (
    //     completion_percentage BETWEEN 0 AND 100
    // ai_notes TEXT,
    // created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    public static function create(int $user_id ,array $roadmap  )
    {

        $connection = Database::getInstance()->getConnection();
        // $user_id = User::getAuthUser()['id'];
        // if (!$user_id) throw new \Exception('not authenticated');
        // $roadmap = Roadmap::getRoadmap($user_id);
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
