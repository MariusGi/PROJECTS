<?php

declare(strict_types = 1);

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = new Database();
    }

    public function register(array $data)
    {
        $this->db->query("INSERT INTO {$this->table} (username, password)
                              VALUES(:username, :password)");
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if ($this->db->execute()) {
            return true;
        }

        return false;
    }

    // Login User
    public function login($username, $password)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE username = :username");
        $this->db->bind(':username', $username);

        $row = $this->db->single();
        $hashed_password = $row->password;

        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function findUserByUsername($username)
    {
        $this->db->query("SELECT id FROM {$this->table} WHERE username = :username");

        // Bind value
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        }

        return false;
    }
}