<?php

namespace NotesApp\Controllers;
use NotesApp\Services\AuthService;

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function SignUp()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'];
        $email = $input['email'];
        $password = $input['password'];

        if ($email === null || $username === null || $password === null) {
            echo json_encode(['error' => 'Please fill all fields']);
            return;
        }
        
        $response = $this->authService->signUp($username, $email, $password);
        echo json_encode($response);
    }

    public function SignIn()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'];
        $password = $input['password'];
        if ($email === null || $password === null) {
            echo json_encode(['error' => 'email and password are required']);
            return;
        }
        $response = $this->authService->signIn($email, $password);
        echo json_encode($response);
    }

    public function SignOut()
    {
        $response = $this->authService->signOut();
        echo json_encode($response);
    }
}
