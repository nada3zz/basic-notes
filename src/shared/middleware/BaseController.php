<?php

namespace NotesApp\Controllers;

use NotesApp\Utils\Database;
use Exception;

abstract class BaseController
{
    protected $database;
    protected $db;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->db = $this->database->connect();
    }

    protected function respondWithError($message, $statusCode = 400)
    {
        http_response_code($statusCode);
        echo json_encode(['message' => $message]);
    }
}
