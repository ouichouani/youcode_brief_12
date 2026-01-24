<?php


namespace App\Models;

use App\core\Database;
use PDO;

class Questionnaire
{
    public static function getAll(): array
    {
        $connection = Database::getInstance()->getConnection();
        $request = "SELECT * from question ORDER BY id ASC";
        $stmt =  $connection->prepare($request);
        $stmt->execute() ;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

       
    // public function saveResponse(array $data): bool
    // {
    //     $connection = Database::getInstance()->getConnection();
    //     $request = "INSERT INTO questions VALUES ?";
    //     $stmt =  $connection->prepare($request);
    //     return $stmt->execute([$data]);
    // }



    // public function getResponses($userId): array
    // {
    //     $request = "SELECT r.*, q.content 
    //                 FROM {$this->responsesTable} r 
    //                 JOIN {$this->questionsTable} q ON r.question_id = q.id 
    //                 WHERE r.user_id = ?";
    //     $stmt = $this->db->prepare($request);
    //     $stmt->execute([$userId]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function generateRoadmapForUser($userId): string
    // {
    //     $responses = $this->getResponses($userId);
    //     if (empty($responses)) {
    //         return "No responses found for user.";
    //     }
    //     return $this->ai->generateRoadmap($responses);
    // }
}
