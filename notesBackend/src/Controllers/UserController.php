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
        if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
            echo json_encode(['error' => 'Username, Email, Password are required']);
            return;
        }

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format']);
            return;
        }

        if (strlen($password) < 6) {
            echo json_encode(['error' => 'Password must be at least 6 characters long']);
            return;
        }

        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password = $password;


        $newUserId = $this->userModel->createUser();

        if ($newUserId) {
            echo "User created Successfully with ID: $newUserId";
        } else {
            echo "User creation failed.";
        }
    }

    public function logIn()
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            echo json_encode(['error' => 'Email and Password are required']);
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

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
