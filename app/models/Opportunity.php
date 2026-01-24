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
        $connection = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM opportunities where user_id = ? ORDER BY created_at DESC ";
        $stmt = $connection->prepare($sql);
        $stmt->execute([User::getAuthUser()['id']]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //get Opportunity by id
    public static function getById($id)
    {
        $connection = Database::getInstance()->getConnection();
        $query = "SELECT * FROM opportunities WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function getLast(): array
    {
        $opportunities = self::getAll();
        if (empty($opportunities)) {
            return [];
        }
        return $opportunities[0];
    }

    public static function save(array $content):bool
    {
        $connection = Database::getInstance()->getConnection();
        $sql = "INSERT INTO opportunities (user_id , title , description , estimated_income , external_link , market_source ) values (? , ? , ? , ? , ? , ?)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([User::getAuthUser()['id'], $content['title'], $content['description'], $content['estimated_income'], $content['external_link'] ,  $content['market_source']]);
        return true ;
    }
}

// id SERIAL PRIMARY KEY,
//     user_id BIGINT REFERENCES users (id) ON DELETE SET NULL ,
//     title VARCHAR(255) NOT NULL,
//     description TEXT,
//     estimated_income NUMERIC(10, 2),
//     external_link TEXT,
//     market_source market_source_enum,