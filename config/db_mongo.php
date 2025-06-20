<?php

declare(strict_types=1);

/**
 * Returns a singleton instance of MongoDB\Client.
 *
 * This function uses a static variable to store and reuse the same
 * MongoDB\Client instance across multiple calls, avoiding repeated connections.
 *
 * @return MongoDB\Client The MongoDB client instance.
 */
function getMongoClient(): MongoDB\Client
{
    static $client = null;

    if ($client === null) {
        $dsn = $_ENV['DB_MONGO_DSN'] ?? 'mongodb://localhost:27017';
        $client = new MongoDB\Client($dsn);
    }

    return $client;
}


/**
 * Returns a singleton instance of MongoDB\Database.
 *
 * This function selects the MongoDB database (from .env or default),
 * using the MongoDB\Client created via getMongoClient().
 *
 * @return MongoDB\Database The selected MongoDB database instance.
 */
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

