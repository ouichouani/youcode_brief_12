<?php
namespace App\Models;

use App\Core\Database;
// use PDO;
use App\Models\User;

class Opportunity
{
    //get tout les Opportunity 

    public static function getAll()
    {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM opportunities where user_id = ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([User::getAuthUser()['id']]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public static function getById($id)
    {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM opportunities WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public static function create(int $userId, string $title, string $description, int $estimated_income, string $difficulty, string $external_link = null): bool
    {
        $db = Database::getInstance()->getConnection();

        // Use difficulty as column name since it's used in the existing code
        $sql = "INSERT INTO opportunities (user_id, title, description, estimated_income, difficulty, external_link) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([$userId, $title, $description, $estimated_income, $difficulty, $external_link]);


        // if th eexternal link is not stored you get rendred to the opportunity details page
        if ($success && empty($external_link)) {
            $id = $db->lastInsertId();
            // Store internal link if no external link was provided
            $link = APP_ROOT . "/opportinity?id=" . $id;
            $updateSql = "UPDATE opportunities SET external_link = ? WHERE id = ?";
            $updateStmt = $db->prepare($updateSql);
            $updateStmt->execute([$link, $id]);
        }

        return $success;
    }
}
