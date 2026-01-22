<?php
namespace App\Models;

use App\Core\Database;
// use PDO;
use App\Models\User ;

class Opportunity {
    //get tout les Opportunity 
    
    public static function getAll() {
    $db = Database::getInstance()->getConnection();
    $sql = "SELECT * FROM opportunities where user_id = ? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([User::getAuthUser()['id']]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);

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
