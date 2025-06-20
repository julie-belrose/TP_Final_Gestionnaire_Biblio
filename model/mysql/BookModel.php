<?php

declare(strict_types=1);

namespace App\Model\Mysql;

use PDO;
use PDOException;

class BookModel
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }
}
