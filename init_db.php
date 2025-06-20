<?php
declare(strict_types=1);

require_once __DIR__ . '/config/env_loader.php';
require_once __DIR__ . '/config/db_mysql.php';

loadEnv(__DIR__ . '/.env');

$pdo = getDbConnection();

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
        importSqlFile($pdo, __DIR__ . '/database/schema.sql');
    }

    if ($runSeed || (!$runSchema && !$runSeed && askConfirmation('→ Do you want to insert sample data (seed)?'))) {
        importSqlFile($pdo, __DIR__ . '/database/seed.sql');
    }

    echo PHP_EOL . "Done !" . PHP_EOL;
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
