<?php

class DbAuthentication {
    private $str;

    public function __construct($str) {
        $this->str = $str;
    }

    public function login($username, $password, $rememberMe) {

        $db = pg_connect($this->str);

        $result = pg_query($db, "SELECT * FROM users");

        $storedPassword = pg_fetch_assoc($result)['password'];

        pg_close($db);

        if ($this->isLogged()) {
            if ($rememberMe) {
                setcookie('username', $username, time() + 86400);
                setcookie('password', $password, time() + 86400);
            }

            $_SESSION['username'] = $username;
            return true;
        } elseif ($password === $storedPassword) {
            $_SESSION['username'] = $username;
            return true;
        }

        return false;
    }

    public function isLogged() {
        if (isset($_SESSION['username'])) {
            return true;
        }

        if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
            return $this->login($_COOKIE['username'], $_COOKIE['password'], true);
        }

        return false;
    }

    public function logout() {
        session_destroy();
        setcookie('username', '', time() - 3600);
        setcookie('password', '', time() - 3600);
    }
}
