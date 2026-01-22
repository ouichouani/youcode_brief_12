<?php


namespace App\Models;

use App\Core\Database;
use Dotenv\Dotenv;
use PDO;

Dotenv::createImmutable(__DIR__ . '.env')->load();
class Questionnaire
{

    private string $tableName = "questions";
    private PDO $db;
    private AI $ai;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->ai = new AI($_ENV['HF_TOKEN']);
    }


    public function getAllQuest(): bool | array
    {
        $request = "select * from ?";
        $stmt =  $this->db->prepare($request);
        if ($stmt->execute([$this->tableName])) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    public function saveResponse(array $data): bool
    {
        $request = "insert into ? values ?";
        $stmt =  $this->db->prepare($request);
        return $stmt->execute([$this->tableName, $data]);
    }
    public function response(){
        $this->ai->generateResponse();
    }
}

