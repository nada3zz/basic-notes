<?php

require_once __DIR__ . '/../vendor/autoload.php';

use NotesApp\Controllers\NoteController;
use NotesApp\Controllers\UserController;
use NotesApp\Models\NoteModel;
use NotesApp\Models\UserModel;
use NotesApp\Utils\Database;



$database= new Database();
$db = $database->connect();

$noteModel = new NoteModel($db);
$userModel = new UserModel($db);

$noteController = new NoteController($database, $noteModel);
$userController = new UserController($database, $userModel);


//routes

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$base_path = '/luftborn-task/notesBackend/src/index.php';


if ($method === 'POST' && $request_uri === $base_path .'/register') {
    $userController->register();
} elseif ($method === 'POST' && $request_uri === $base_path .'/login'){
    $userController->logIn();
} elseif($method === 'POST' && $request_uri === $base_path .'/logout'){
    $userController->logOut();
}
elseif ($method === 'GET' && $request_uri === $base_path .'/notes') {
    $noteController->getAllNotes();
} elseif ($method === 'GET' && preg_match('/\/notes\?id=\d+/', $request_uri)) {
    $noteController->getNoteById();
} elseif ($method === 'POST' && $request_uri === $base_path .'/notes') {
    $noteController->createNote();
} elseif ($method === 'PUT' && preg_match('/\/notes\?id=\d+/', $request_uri)) {
    $noteController->updateNote();
} elseif ($method === 'DELETE' && preg_match('/\/notes\?id=\d+/', $request_uri)) {
    $noteController->DeleteNote();
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not Found']);
}

