<?php

class Authentication {
    private $usersFile;

    public function __construct($usersFile) {
        $this->usersFile = $usersFile;
    }

    public function login($username, $password) {
        $users = file($this->usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($users as $user) {
            list($storedUsername, $storedPassword) = explode(':', $user);

            if ($username === $storedUsername && $password === $storedPassword) {
                $_SESSION['username'] = $username;
                return true;
            }
        }

        return false;
    }

    public function logout() {
        unset($_SESSION['username']);
    }

    public function isLogged() {
        return isset($_SESSION['username']);
    }
}
