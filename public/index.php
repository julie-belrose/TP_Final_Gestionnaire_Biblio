<?php

use App\Model\Mongo\ReviewModel;
use App\Model\Mysql\BookModel;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

require_once __DIR__ . '/../config/env_loader.php';

$pdo = require_once __DIR__ . '/../config/db_mysql.php';
$mongoDb = require_once __DIR__ . '/../config/db_mongo.php';

$bookModel = new BookModel($pdo);
$reviewModel = new ReviewModel($mongoDb);

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
