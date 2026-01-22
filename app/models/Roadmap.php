<?php


namespace App\Models;

use App\Core\Database;
use PDO;
class Roadmap
{
    private string $tablename = "roadmaps";
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getRoadmap($userId): array
    {
        $request = "SELECT * FROM {$this->tablename} WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
        $stmt = $this->db->prepare($request);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function saveRoadmap($userId, $content): bool
    {
        $request = "INSERT INTO {$this->tablename} (user_id, content) VALUES (?, ?)";
        $stmt = $this->db->prepare($request);
        return $stmt->execute([$userId, $content]);
    }
}
