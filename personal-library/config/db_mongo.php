<?php

declare(strict_types=1);

function getMongoClient(): MongoDB\Client
{
    static $client = null;
    
    if ($client === null) {
        $dsn = $_ENV['DB_MONGO_DSN'] ?? 'mongodb://localhost:27017';
        $client = new MongoDB\Client($dsn);
    }
    
    return $client;
}

function getMongoDatabase(): MongoDB\Database
{
    static $database = null;
    
    if ($database === null) {
        $client = getMongoClient();
        $databaseName = $_ENV['DB_MONGO_NAME'] ?? 'personal_library';
        $database = $client->selectDatabase($databaseName);
    }
    
    return $database;
}
