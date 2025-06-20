<?php

declare(strict_types=1);

/**
 * Returns a singleton PDO connection to the MySQL database.
 *
 * This function ensures that the PDO connection is instantiated only once.
 * It uses environment variables to configure the DSN, user, and password.
 *
 * Environment variables used:
 * - DB_MYSQL_HOST (default: localhost)
 * - DB_MYSQL_NAME (default: personal_library)
 * - DB_MYSQL_USER (default: root)
 * - DB_MYSQL_PASSWORD (default: empty string)
 *
 * @return PDO The PDO instance connected to the MySQL database.
 *
 * @throws PDOException if the connection fails.
 */
function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            $_ENV['DB_MYSQL_HOST'] ?? 'localhost',
            $_ENV['DB_MYSQL_NAME'] ?? 'personal_library'
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,         // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // Return rows as associative arrays
            PDO::ATTR_EMULATE_PREPARES => false,                 // Use real prepared statements
        ];

        $pdo = new PDO(
            $dsn,
            $_ENV['DB_MYSQL_USER'] ?? 'root',
            $_ENV['DB_MYSQL_PASSWORD'] ?? '',
            $options
        );
    }

    return $pdo;
}

