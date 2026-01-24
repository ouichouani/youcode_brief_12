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

        $stmt = $db->prepare("INSERT INTO posts (user_id, title, content, status, ai_score, is_high_value, type) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // Add default type 'experience' for now as per schema
        return $stmt->execute([$userId, $title, $content, $status, $score, $isHighValue ? 1 : 0, 'experience']);
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

    public function getComments(int $postId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT c.*, u.name as author 
                             FROM comments c 
                             JOIN users u ON c.user_id = u.id 
                             WHERE c.post_id = ? 
                             ORDER BY c.created_at ASC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function toggleLike(int $postId, int $userId)
    {
        $db = Database::getInstance()->getConnection();

        // Check if already liked
        $stmt = $db->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
        $like = $stmt->fetch();

        if ($like) {
            $stmt = $db->prepare("DELETE FROM likes WHERE id = ?");
            return $stmt->execute([$like['id']]);
        } else {
            $stmt = $db->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
            return $stmt->execute([$postId, $userId]);
        }
    }

    public function getLikesCount(int $postId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetchColumn();
    }

    public function isLiked(int $postId, int $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
        return $stmt->fetchColumn() > 0;
    }
}
