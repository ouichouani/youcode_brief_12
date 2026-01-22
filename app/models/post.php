<?php
namespace App\Models;

use App\Core\Database;

class Post {
    public static function addPost($content){
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO Post(content) VALUES (?)");
        return $stmt->execute([$content]);
    }

    public static function getAll(){
        $db=Database::getInstance()->getConnection();
        $stmt =$db->prepare("SELECT*FROM post");
        return $stmt->execute();
    }
}
