<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Core\Database;

$db = Database::getInstance()->getConnection();

function addColumnIfMissing($db, $table, $column, $type)
{
    try {
        $stmt = $db->prepare("SELECT column_name FROM information_schema.columns WHERE table_name = ? AND column_name = ?");
        $stmt->execute([$table, $column]);
        if (!$stmt->fetch()) {
            echo "Adding column $column to table $table...\n";
            $db->exec("ALTER TABLE $table ADD COLUMN $column $type");
        } else {
            echo "Column $column already exists in table $table.\n";
        }
    } catch (Exception $e) {
        echo "Error checking/adding column $column in $table: " . $e->getMessage() . "\n";
    }
}

// Fix skills table
addColumnIfMissing($db, 'skills', 'roadmap_id', 'INTEGER');

// Fix tasks table
addColumnIfMissing($db, 'tasks', 'user_id', 'INTEGER');
addColumnIfMissing($db, 'tasks', 'skill_name', 'VARCHAR(255)');
addColumnIfMissing($db, 'tasks', 'is_completed', 'SMALLINT DEFAULT 0');

echo "Database fix completed.\n";
