<?php

require __DIR__ . '/../vendor/autoload.php';

use danog\MadelineProto\API;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$API_ID = $_ENV['API_ID'];
$API_HASH = $_ENV['API_HASH'];

$settings = (new \danog\MadelineProto\Settings\AppInfo)
    ->setApiId($API_ID)
    ->setApiHash($API_HASH);

$mlnProto = new API('session.madeline', $settings);

$mlnProto->start();

$me = $mlnProto->getSelf();

var_dump($me);

$mlnProto->messages->sendMessage([
    'peer' => 'me',
    'message' => 'Привет! Это MadelineProto :)',
]);
