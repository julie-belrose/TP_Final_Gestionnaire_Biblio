<?php
declare(strict_types=1);

/**
 * ----------------------------------------------------------
 * init_db.php – Initialize your MySQL database (schema + data)
 * ----------------------------------------------------------
 *
 * This script lets you initialize your database either interactively
 * or automatically using CLI flags.
 *
 * USAGE:
 *   php init_db.php                 → interactive mode (asks before importing)
 *   php init_db.php --auto-schema  → import schema only, no confirmation
 *   php init_db.php --auto-seed    → import sample data only, no confirmation
 *   php init_db.php --all          → import both schema and seed automatically
 *
 * Make sure your .env file is correctly set before running.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Charge les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Connexion temporaire SANS base sélectionnée
$dsn = sprintf('mysql:host=%s;charset=utf8mb4', $_ENV['DB_MYSQL_HOST'] ?? 'localhost');
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO(
    $dsn,
    $_ENV['DB_MYSQL_USER'] ?? 'root',
    $_ENV['DB_MYSQL_PASSWORD'] ?? '',
    $options
);

// Création de la base si elle n'existe pas
$dbName = $_ENV['DB_MYSQL_NAME'] ?? 'personal_library';
$pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

// Reconnexion avec la base
$pdo = new PDO(
    sprintf('%s;dbname=%s', $dsn, $dbName),
    $_ENV['DB_MYSQL_USER'] ?? 'root',
    $_ENV['DB_MYSQL_PASSWORD'] ?? '',
    $options
);


//$pdo = getDbConnection();

/**
 * Prompt the user interactively.
 */
function askConfirmation(string $question): bool
{
    echo $question . ' [Y/n] ';
    $handle = fopen("php://stdin", "r");
    $input = trim(fgets($handle));
    fclose($handle);

    return in_array(strtolower($input), ['', 'y', 'yes'], true);
}

/**
 * Executes all SQL statements in a file.
 */
function importSqlFile(PDO $pdo, string $filePath): void
{
    if (!file_exists($filePath)) {
        throw new RuntimeException("SQL file not found: $filePath");
    }

    $sql = file_get_contents($filePath);
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $stmt) {
        if ($stmt !== '') {
            $pdo->exec($stmt);
        }
    }

    echo "Imported: " . basename($filePath) . PHP_EOL;
}

/**
 * Parses command line flags.
 */
function getFlags(): array
{
    global $argv;
    return array_slice($argv, 1);
}

// ────── SCRIPT FLOW ──────
try {
    echo "🔧 Initializing MySQL database...\n";
    $flags = getFlags();

    $runSchema = in_array('--auto-schema', $flags) || in_array('--all', $flags);
    $runSeed = in_array('--auto-seed', $flags) || in_array('--all', $flags);

    if ($runSchema || (!$runSeed && askConfirmation('→ Do you want to create the schema (tables)?'))) {
        importSqlFile($pdo, __DIR__ . '/../src/database/mysql/schema.sql');
    }

    if ($runSeed || (!$runSchema && !$runSeed && askConfirmation('→ Do you want to insert sample data (seed)?'))) {
        importSqlFile($pdo, __DIR__ . '/../src/database/mysql/seed.sql');
    }

    echo PHP_EOL . "Done !" . PHP_EOL;
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
