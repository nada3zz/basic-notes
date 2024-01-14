<?php

namespace NotesApp\Services;
use NotesApp\Utils\Database;
use NotesApp\Utils\JwtUtil;

class AuthService
{
    public function signUp($username, $email, $password)
    {
        if (!$this->isEmailAvailable($email)) {
            return ['error' => 'This email is already in use'];
        }

        $pdo = Database::connect();
        $hashedPassword = password_hash($password, 'PASSWORD_BCRYPT');
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        return ['message' => 'User registered successfully'];
    }

    public function signIn($email, $password)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
        $config = include_once(__DIR__ . '/../Config/env.php');

        if ($userData && password_verify($password, $userData['password'])) {
            $tokenData = ['user_id' => $userData['id'], 'username' => $userData['username']];
            $secretKey = $config['SECRET_KEY'];
            $token = JwtUtil::generateToken($tokenData, $secretKey);

            return ['token' => $token];
        } else {
            return ['error' => 'Invalid credentials'];
        }

    }

    
    public function signOut()
    {
        return ['message' => 'User signed out'];
    }

    private function isEmailAvailable($email)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        return $count === 0;
    }
}
