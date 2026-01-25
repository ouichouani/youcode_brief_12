<?php

namespace App\Models;

use App\Core\Database;
// use App\Models\User;


class Skill
{

    public static function getSkills(int $user_id, int $roadmap_id)
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM skills WHERE  user_id = ? AND roadmap_id = ? ");
        $stmt->execute([$user_id, $roadmap_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function create(int $userId, int $roadmapId, string $name, string $description = null, string $category = null): bool
    {
        $connection = Database::getInstance()->getConnection();
        $stmt = $connection->prepare("INSERT INTO skills (user_id, roadmap_id, name, description, category) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $roadmapId, $name, $description, $category]);
    }

}