<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NotesApp\Controllers\NoteController;
use NotesApp\Controllers\AuthController;


$noteController = new NoteController();
$userController = new AuthController();

header('Content-Type: application/json');

$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'POST' && $request_uri === '/signup') {
        $authController->signUp();
    } elseif ($method === 'POST' && $request_uri === '/signin') {
        $authController->signIn();
    } elseif ($method === 'POST' && $request_uri === '/signout') {
        $authController->signOut();
    } elseif ($method === 'GET' && strpos($request_uri, '/notes') === 0) {
        $noteController->get(parse_url($request_uri, PHP_URL_PATH));
    } elseif ($method === 'POST' && $request_uri === '/notes') {
        $noteController->create();
    } elseif ($method === 'PUT' && preg_match('/\/notes\/(\d+)/', $request_uri, $matches)) {
        $noteController->update(['id' => $matches[1]]);
    } elseif ($method === 'DELETE' && preg_match('/\/notes\/(\d+)/', $request_uri, $matches)) {
        $noteController->delete(['id' => $matches[1]]);
    } else {
        throw new Exception('Not Found', 404);
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()]);
}