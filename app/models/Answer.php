<?php

namespace App\Models;

use App\core\Database;

class Answer
{


    public static function getAll(int $user_id)
    {

        $connection = Database::getInstance()->getConnection();
        $request = "SELECT * FROM answers where user_id = ?  ORDER BY question_id ASC";
        $stmt = $connection->prepare($request);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function saveResponse($userId, array $responses): bool
    {
        $connection = Database::getInstance()->getConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO answers (user_id, question_id, content) VALUES (?, ?, ?)");

            foreach ($responses as $questionId => $responseText) {
                $stmt->execute([$userId, (int) $questionId, $responseText]);
            }

            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        }
    }

    
}
