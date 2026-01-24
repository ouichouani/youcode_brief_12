<?php

namespace App\Models;

use App\Core\Database;
use App\Models\AI;

class Community
{
    /**
     * Define Database Tables (Schema Design)
     * --------------------------------------
     * posts: id, user_id, title, content, status(approved, flagged, rejected), ai_score, is_high_value, created_at
     * comments: id, post_id, user_id, content, created_at
     * likes: id, user_id, post_id, comment_id, created_at
     */

    public function createPost(int $userId, string $title, string $content)
    {
        $db = Database::getInstance()->getConnection();

        // AI Moderation Step
        $moderationRaw = AI::moderateContent($content);
        $mod = json_decode($moderationRaw, true);

        $status = $mod['status'] ?? 'approved';
        $score = $mod['score'] ?? 0;
        $isHighValue = $mod['is_high_value'] ?? false;

        $stmt = $db->prepare("INSERT INTO posts (user_id, title, content, status, ai_score, is_high_value) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $content, $status, $score, $isHighValue]);
    }

    public function getFeed($limit = 20)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT p.*, u.name as author 
                             FROM posts p 
                             JOIN users u ON p.user_id = u.id 
                             WHERE p.status = 'approved' 
                             ORDER BY p.is_high_value DESC, p.created_at DESC 
                             LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addComment(int $postId, int $userId, string $content)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$postId, $userId, $content]);
    }
}
