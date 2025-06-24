<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

use App\App;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../')->load();

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

if (str_starts_with($contentType, 'application/json')) {
    $request = json_decode(file_get_contents('php://input'), true) ?? [];
} else {
    $request = $_POST;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($request['token']) || $request['token'] != $_ENV['TOKEN_KEY']) {
    http_response_code(403);
    exit;
}

if (empty($request['cmd'])) {
    http_response_code(400);
    echo json_encode(['error' => "Param 'cmd' required"]);
    exit;
}

$app = new App();
$app->start();

if (empty($request['params'])) {
    echo $app->run($request['cmd']);
} else {
    echo $app->run($request['cmd'], $request['params']);
}
