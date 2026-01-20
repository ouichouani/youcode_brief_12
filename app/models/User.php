<?php

use App\core\Database;


class User {


    public static function register(string $fullName, string $email, string $password): bool{
        $connection = Database::getInstance()->getConnection() ;
        $stmt = $connection->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$fullname, $email, $password]);
    }

    
    public static function getByEmail($email){
        $connection = Database::getInstance()->getConnection() ;
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ;    

    }


    public function show(int $id){
        $connection = Database::getInstance()->getConnection() ;
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ;  
    }



} 
?>