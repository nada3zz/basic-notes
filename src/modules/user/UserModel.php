<?php

namespace NotesApp\Models;

class UserModel
{
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct(\PDO $db)
    {
        $this->conn = $db;
    }

    public function createUser()
    {
        try {
            $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
            $query = 'INSERT INTO ' . $this->table . ' SET username = :username, email = :email, password = :password';

            $stmt = $this->conn->prepare($query);

            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }

            return false;
        } catch (\PDOException $e) {
            error_log('Error: ' . $e->getMessage());
        }
    }

    public function getUsersWithReminder()
    {
        try {
            $query = 'SELECT username, email, n.reminder FROM ' . $this->table . ' as u
            JOIN notes as n ON u.id = n.user_id 
            WHERE n.reminder IS NOT NULL
            ORDER BY n.reminder DESC';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();

            $users = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $users;
           
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        $query = 'SELECT id, username, email, password FROM ' . $this->table . ' WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);

        try {
            if ($stmt->execute()) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        unset($user['password']);
                        return $user;
                    }
                }
            }
        } catch (\PDOException $e) {

            echo 'Error: ' . $e->getMessage();
        }

        return false;
    }

}
