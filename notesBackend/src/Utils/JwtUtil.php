<?php

namespace NotesApp\Utils;
use Firebase\JWT\JWT;

class JwtUtil
{
    private static $secretKey = '';

    private static function loadSecretKey()
    {
        if (empty(self::$secretKey)) {
            $config = include_once(__DIR__ . '/../Config/env.php');
            self::$secretKey = $config['SECRET_KEY'];
        }
    }

    public static function generateToken($data, $expirationMinutes = 60)
    {
        self::loadSecretKey();

        $issuedAt = time();
        $expirationTime = $issuedAt + ($expirationMinutes * 60);

        $token = [
            'iat' => $issuedAt, 
            'exp' => $expirationTime, 
            'data' => $data,
        ];

        return JWT::encode($token, self::$secretKey, 'HS256');
    }

    public static function decodeToken($token)
    {
        self::loadSecretKey();

        try {
            $decoded = JWT::decode($token, self::$secretKey);
            return (array) $decoded->data;
        } catch (\Exception $e) {
        
            return false;
        }
    }
}
