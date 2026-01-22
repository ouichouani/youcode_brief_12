<?php
namespace App\models;

use App\core\Database;

class Tasks {
    // Get all tasks
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM tasks");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Update status ta3 task
    public static function markAsDone($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("UPDATE tasks SET status = 'done' WHERE id = ?");
        return $stmt->execute([$id]);
    }


}



