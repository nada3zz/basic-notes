<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();
 
return [
    'host' => $_ENV['DB_HOST'],
    'dbname' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'SECRET_KEY' => $_ENV['SECRET_KEY'],
    'smtp_username' => $_ENV['SMTP_USERNAME'],
    'smtp_password' => $_ENV['SMTP_PASSWORD'],
];