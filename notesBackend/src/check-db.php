<?php

require_once 'Utils/Database.php';
use NotesApp\Utils\Database;

try {
    $pdo = Database::connect();
    echo "Database connection successful!";
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
