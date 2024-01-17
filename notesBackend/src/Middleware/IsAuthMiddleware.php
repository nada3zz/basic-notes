<?php

namespace NotesApp\Middleware;
use NotesApp\Utils\JwtUtil;


class IsAuthMiddleware
{
    private static function validateToken($authHeader)
    {
        if (empty($authHeader)) {
            http_response_code(401);
            die('Not authenticated.');
        }

        list($tokenType, $token) = explode(' ', $authHeader);

        if (strcasecmp($tokenType, 'Bearer') !== 0) {
            http_response_code(401);
            die('Invalid token type.');
        }

        $userData = JwtUtil::decodeToken($token);

        if ($userData === false) {
            http_response_code(401);
            die('Invalid token.');
        }

        return $userData;
    }

    public static function authenticate()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        self::validateToken($authHeader);
    }

    public static function logout()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $userData = self::validateToken($authHeader);
        $newToken = JwtUtil::generateToken($userData, 1);

        echo json_encode(['status' => 'success', 'message' => 'User signed out successfully', 'new_token' => $newToken]);
        exit;
    }
}
