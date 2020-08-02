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

            return true;
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
        $data = [
            'password' => '',
            'password_err' => '',
        ];

        $this->view('users/login', $data);
    }
}
