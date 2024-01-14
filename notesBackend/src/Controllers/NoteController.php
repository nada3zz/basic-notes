<?php

namespace NotesApp\Controllers;
use NotesApp\Services\NoteService;
use NotesApp\Utils\JwtUtil;

class NoteController
{
    private $noteService;

    public function __construct()
    {
        $this->noteService = new NoteService();
    }

    public function get($vars)
    {
        $token = $this->getTokenFromHeaders();

        if (!$token) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId = $this->getUserIdFromToken($token);

        if (!$userId) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        if (isset($vars['id'])) {
            $noteId = $vars['id'];
            $response = $this->noteService->getNoteById($noteId);
        } else {
            $response = $this->noteService->getUserNotes($userId);
        }

        echo json_encode($response);
    }
    

    public function create()
{
    $token = $this->getTokenFromHeaders();

    if (!$token) {
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }

    $userId = $this->getUserIdFromToken($token);

    if (!$userId) {
        echo json_encode(['error' => 'Unauthorized']);
        return;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $title = $input['title'] ?? null;
    $content = $input['content'] ?? null;
    $reminder = $input['reminder'];

    if ($title === null || $content === null) {
        echo json_encode(['error' => 'Title and content are required']);
        return;
    }

    $response = $this->noteService->createNote($userId, $title, $content, $reminder);

    echo json_encode($response);
}


public function update($vars)
   {
        $token = $this->getTokenFromHeaders();

        if (!$token) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId = $this->getUserIdFromToken($token);

        if (!$userId) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $noteId = $vars['id'];
        $title = $input['title'];
        $content = $input['content'];
        $reminder = $input['reminder'];

        $response = $this->noteService->updateNote($noteId, $title, $content, $reminder);
        echo json_encode($response);
    }
    

    public function delete($vars)
    {
        $token = $this->getTokenFromHeaders();

        if (!$token) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId = $this->getUserIdFromToken($token);

        if (!$userId) {
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $noteId = $vars['id'];
        $response = $this->noteService->deleteNote($noteId);
        echo json_encode($response);
    }


    private function getTokenFromHeaders()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization']) && strpos($headers['Authorization'], 'Bearer ') === 0) {
            return trim(substr($headers['Authorization'], 7));
        }

        return null;
    }

    private function getUserIdFromToken($token)
    {
        $config = include_once(__DIR__ . '/../Config/env.php');
        $secretKey = $config['SECRET_KEY']; 
        $tokenData = JwtUtil::decodeToken($token, $secretKey);

        return isset($tokenData['user_id']) ? $tokenData['user_id'] : null;
    }

}
