<?php

declare(strict_types=1);

use App\Controller\BookController;
use App\Model\Mysql\BookModel;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../src/Config/db_mysql.php';

$pdo = getDbConnection();
$bookModel = new BookModel($pdo);
$controller = new BookController($bookModel);

$books = $controller->listBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; background: #f9f9f9; }
        li { margin-bottom: 1rem; background: #fff; padding: 1rem; border-radius: 5px; box-shadow: 0 0 3px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<h1>Book List</h1>
<ul>
    <?php foreach ($books as $book): ?>
        <li>
            <strong><?= htmlspecialchars($book['title']) ?></strong><br>
            Author: <?= htmlspecialchars($book['author']) ?><br>
            ISBN: <?= htmlspecialchars($book['isbn']) ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
