<?php


namespace App\Models;

use App\core\Database;
use PDO;
use Exception;

class Questionnaire
{
    private string $questionsTable = 'question';
    private string $responsesTable = 'user_responses';
    private PDO $db;
    private AI $ai;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->ai = new AI();
    }

    public function getAllQuest(): array
    {
        $request = "SELECT * FROM {$this->questionsTable} ORDER BY id ASC";
        $stmt = $this->db->prepare($request);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveResponse($userId, array $responses): bool
    {
        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->responsesTable} (user_id, question_id, response_text) VALUES (?, ?, ?)");
            foreach ($responses as $questionId => $responseText) {
                $stmt->execute([$userId, (int) $questionId, $responseText]);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;

        }
    }

    public function getResponses($userId): array
    {
        $request = "SELECT r.*, q.question_text 
                    FROM {$this->responsesTable} r 
                    JOIN {$this->questionsTable} q ON r.question_id = q.id 
                    WHERE r.user_id = ?";
        $stmt = $this->db->prepare($request);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function generateRoadmapForUser($userId): string
    {
        $responses = $this->getResponses($userId);
        if (empty($responses)) {
            return "No responses found for user.";
        }
        return $this->ai->generateRoadmap($responses);
    }
}

