<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/engine/helpers.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}


$page = new Page();
$mysql = new Mysql();
$mysql->connect($page->getMysqlHost(), $page->getMysqlLogin(), $page->getMysqlPassword(), $page->getMysqlDb(), $page->debugLevel);
$user = new User($mysql);
if ($user->isLoggedIn()) {
    header("Location: /");
    exit;
}
$logs = new Logs();
$data = new Data();

$login = isset($_POST["login"]) ? $_POST["login"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;
$password2 = isset($_POST["password2"]) ? $_POST["password2"] : null;
$email = isset($_POST["email"]) ? $_POST["email"] : null;

if ($login && $password && $password2 && $email) {

    if (strlen($login) < 5) {
        $_SESSION['reg_err2'] = 1;
        $flag = 1;
    }

    if (strlen($password) < 5) {
        $_SESSION['reg_err3'] = 1;
        $flag = 1;
    }

    $query = "SELECT `id` FROM `users` WHERE `email`='$email' LIMIT 1";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows != 0) {
        $_SESSION['reg_err6'] = 1;
        $flag = 1;
    }
    $stmt->close();

    $query = "SELECT `id` FROM `users` WHERE `login`='$login' LIMIT 1";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows != 0) {
        $_SESSION['reg_err4'] = 1;
        $flag = 1;
    }
    $stmt->close();

    if ($password != $password2) {
        $_SESSION['reg_err5'] = 1;
        $flag = 1;
    }

    if ($flag == 1) {
        header('Location: /register/');
        exit;
    }

    $hashed_password = hash('sha256', hash('sha256', $password) . $salt);
    $query = "INSERT INTO `users` SET `login`=?, `email`=?, `password`=?, `salt`=?";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("ssss", $login, $email, $hashed_password, $salt);
    $stmt->execute();
    $stmt->close();
}

$_SESSION['reg_ok'] = 1;
header("Location: /");
