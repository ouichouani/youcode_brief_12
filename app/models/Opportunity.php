<?php
namespace App\Models;

use App\Core\Database;
// use PDO;

class Opportunity {
    //get tout les Opportunity 
    
    public static function getAll() {
    $db = Database::getInstance()->getConnection();
    if($db){
        echo "kyna";
        $sql = "SELECT * FROM opportunities";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }else{
        echo "mkynash";
        return [];
    }
}

    //get Opportunity by id
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM opportunities WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
