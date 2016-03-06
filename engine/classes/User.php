<?php

class User
{
    public $id;
    public $login;
    public $password;
    public $salt;
    public $email;
    public $isAdmin;

    public function __construct()
    {

    }

    public function getSaltFromDb($mysql, $login)
    {
        $query = "SELECT `salt` FROM `users` WHERE `login`=?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows != 1) {
            return false;
        }
        $salt = '';
        $stmt->bind_result($salt);
        $stmt->fetch();
        $stmt->close();
        return $salt;
    }

    public function checkPassword($mysql, $login, $password, $salt)
    {
        $hashed_password = hash('sha256', hash('sha256', $password) . $salt);
        $query = "SELECT `id` FROM `users` WHERE `login`=? AND `password`=?";
        $stmt = $mysql->connection->prepare($query);
        $stmt->bind_param("ss", $login, $hashed_password);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows != 1) {
            return false;
        }
        $id = '';
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        return $id;
    }
}