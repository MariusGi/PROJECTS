<?php

declare(strict_types = 1);

class UsersController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        // Check for not POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Init data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
            ];

            // Load the view
            $this->view('users/register', $data);

            return false;
        }

        // If this is post request
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Init data
        $data = [
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'username_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
        ];

        // Validate username
        if (empty($data['username'])) {
            $data['username_err'] = 'Please enter username';
        } elseif ($this->userModel->findUserByUsername($data['username'])) {
            $data['username_err'] = 'Username is already taken';
        }

        // Validate password
        if (empty($data['password'])) {
            $data['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be at least 6 characters';
        }

        // Validate confirm password
        if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Please confirm password';
        } elseif($data['password'] != $data['confirm_password']) {
            $data['confirm_password_err'] = 'Passwords do not match';
        }

        if (empty($data['username_err']) &&
            empty($data['password_err']) &&
            empty($data['confirm_password_err'])) {

            // Validated
            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Register user
            if ($this->userModel->register($data)) {
                SessionHelper::flash('register_success', 'You are registered and can log in');
                UrlHelper::redirect('users/login');
            } else {
                die('something went wrong');
            }

        } else {
            // Load view with errors
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // Check for not POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',
            ];

            // Load the view
            $this->view('users/login', $data);

            return false;
        }

        // Process the form
        // Sanitaze POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // Init data
        $data = [
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password']),
            'username_err' => '',
            'password_err' => '',
        ];

        // Validate username
        if (empty($data['username'])) {
            $data['username_err'] = 'Please enter username';
        }

        // Validate password
        if (empty($data['password'])) {
            $data['password_err'] = 'Please enter password';
        } elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be at least 6 characters';
        }

        // Check for user/email
        if ($this->userModel->findUserByUsername($data['username'])) {
            // User found
        } else {
            // User not found
            $data['username_err'] = 'No user found';
        }

        // Make sure errors are empty
        if (empty($data['username_err']) &&
            empty($data['password_err'])) {
            // Validated
            // Check and set logged in user
            $loggedInUser = $this->userModel->login($data['username'], $data['password']);

            if ($loggedInUser) {
                // Create Session
                $this->createUserSession($loggedInUser);
            } else {
                $data['password_err'] = 'Password incorrect';
                $this->view('users/login', $data);
            }
        } else {
            // Load view with errors
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        SessionHelper::flash('login_success', 'You have been successfully logged in.');
        UrlHelper::redirect('posts');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
//        session_destroy();
        SessionHelper::flash('logout_success', 'You have been successfully logged out.');
        UrlHelper::redirect('users/login');
    }
}
