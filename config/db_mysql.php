<?php

declare(strict_types=1);

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
    }
    
    return $pdo;
}
