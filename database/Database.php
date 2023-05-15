<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kousha\RoomRaccoon\Core\Kernel;

$kernel = new Kernel();

// Get the database connection from the kernel
$db = $kernel->getContainer('database');

// Get the database type from the configuration
$databaseType = $kernel->getContainer('config')['database']['connection'];

// Check the number of tables in the database
if ($databaseType === 'mysql') {
    $tableCheckQuery = "SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = ?;";
    $tableCheckStmt = $db->prepare($tableCheckQuery);
    $tableCheckStmt->execute([$kernel->getContainer('config')['database']['connection']]);
    $tableCount = (int) $tableCheckStmt->fetch(PDO::FETCH_ASSOC)['count'];
} else { // Assuming SQLite
    $tableCheckQuery = "SELECT COUNT(*) as count FROM sqlite_master WHERE type='table';";
    $result = $db->query($tableCheckQuery);
    $tableCount = (int) $result->fetch(PDO::FETCH_ASSOC)['count'];
}

// If there are no tables, execute all SQL files in the migrations directory
if ($tableCount === 0) {
    $migrationsDir = __DIR__ . '/migrations';
    $sqlFiles = glob($migrationsDir . '/*.sql');

    foreach ($sqlFiles as $file) {
        $query = file_get_contents($file);
        $db->exec($query);
    }
}
