<?php


namespace App\models;

use App\core\Database;
use PDO;
    class Roadmap{
        private string $tablename = "roadmap";
        private PDO $db ;



        public function __construct()
        {
            $this->db = Database::getInstance()->getConnection();
        }
        public function getRoadmap($userId): array{
            $request  = "select * from roadmaps where user_id = ?";
            $stmt = $this->db->prepare($request);
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }