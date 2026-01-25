<?php

namespace App\Models;

use App\Core\Database;

class Task
{
    public static function getAll(int $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY is_completed ASC, created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function create(int $userId, int $planId, string $description, string $skillName = null, string $status = 'pending')
    {
        $db = Database::getInstance()->getConnection();
        // The table has a NOT NULL 'title' column. We'll use the description as title for now if it's short, 
        // or truncate it. Or we can just use the provided description as 'title' and leave 'description' as is.
        $title = strlen($description) > 255 ? substr($description, 0, 252) . "..." : $description;

        $stmt = $db->prepare("INSERT INTO tasks (user_id, plan_id, title, description, skill_name, is_completed, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $isCompleted = ($status === 'completed' ? 1 : 0);
        return $stmt->execute([$userId, $planId, $title, $description, $skillName, $isCompleted, $status]);
    }

    public static function markAsDone(int $taskId, int $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE tasks SET is_completed = 1, status = 'completed' WHERE id = ? AND user_id = ?");
        return $stmt->execute([$taskId, $userId]);
    }

    public static function delete(int $taskId, int $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        return $stmt->execute([$taskId, $userId]);
    }

    public static function getSkillProgress(int $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT 
                skill_name, 
                COUNT(*) as total_tasks, 
                SUM(CASE WHEN is_completed = 1 OR status = 'completed' THEN 1 ELSE 0 END) as completed_tasks
            FROM tasks 
            WHERE user_id = ? AND skill_name IS NOT NULL
            GROUP BY skill_name
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
