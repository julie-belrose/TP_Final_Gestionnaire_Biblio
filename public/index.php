<?php

declare(strict_types=1);

use App\Controller\HomeController;
use App\Model\Mysql\BookModel;
use App\Model\Mongo\ReviewModel;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

$controller = new HomeController();
$controller->index();

// Connexions aux bases de données
require_once __DIR__ . '/../src/Config/db_mysql.php';
require_once __DIR__ . '/../src/Config/db_mongo.php';

$pdo = getDbConnection();
//$mongoDb = getMongoDatabase();

$bookModel = new BookModel($pdo);
//$reviewModel = new ReviewModel($mongoDb);

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

echo "App started!";
