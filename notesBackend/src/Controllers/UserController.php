<?php

namespace NotesApp\Controllers;

use NotesApp\Models\UserModel;
use NotesApp\Utils\Database;
use NotesApp\Utils\JwtUtil;
use NotesApp\Middleware\IsAuthMiddleware;

class UserController extends BaseController
{
    private $userModel;

    public function __construct(Database $database, UserModel $userModel)
    {
        parent::__construct($database);
        $this->userModel = $userModel;
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"));
       
        if (!isset($data->username) || !isset($data->email) || !isset($data->password)) {
            echo json_encode(['message' => 'Username, Email, Password are required']);
            return;
        }

        if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['message' => 'Invalid email format']);
            return;
        }

        if (strlen($data->password) < 6) {
            echo json_encode(['message' => 'Password must be at least 6 characters long']);
            return;
        }

        $this->userModel->username = $data->username;
        $this->userModel->email = $data->email;
        $this->userModel->password = $data->password;


        $newUserId = $this->userModel->createUser();
        
        if ($newUserId) {
            $userDataForToken = ['user_id' => $newUserId, 'username' => $data->username];
            $token = JwtUtil::generateToken($userDataForToken);
    
            $response = [
                'status' => 'success',
                'token' => $token,
                'user_id' => $newUserId,
            ];
    
            echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User creation failed.']);
        }
    }

    public function logIn()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->email) || !isset($data->password)) {
            echo json_encode(['error' => 'Email and Password are required']);
            return;
        }

        $email = $data->email;
        $password = $data->password;

        $authenticatedUser = $this->userModel->login($email, $password);


        if ($authenticatedUser) {

            $userDataForToken = ['user_id' => $authenticatedUser['id'], 'username' => $authenticatedUser['username']];
            $token = JwtUtil::generateToken($userDataForToken);
            $response = [
                'status' => 'success',
                'token' => $token,
                'user_id' => $authenticatedUser['id'],
            ];
            echo json_encode($response);
        } else {

            $response = [
                'status' => 'error',
                'message' => 'Invalid credentials',
            ];

            echo json_encode($response);
        }
    }

    public function logOut()
    {
        IsAuthMiddleware::logout();
    }
}
