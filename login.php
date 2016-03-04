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
$user = new User();
$logs = new Logs();
$data = new Data();

if ($_GET['logout'] == 1) {
    unset($_SESSION['id']);
    unset($_SESSION['login']);
    header("Location: /");
    exit();
}

$login = isset($_POST["login"]) ? $_POST["login"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;

if ($login && $password) {
    $query = "SELECT `salt` FROM `users` WHERE `login`=?";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    if ($stmt->num_rows != 1) {
        echo "cant't find user or find more than one user";
        exit;
    }
    $salt = '';
    $stmt->bind_result($salt);
    $stmt->fetch();
    $hashed_password = hash('sha256', hash('sha256', $password) . $salt);
    $query = "SELECT `id` FROM `users` WHERE `login`=? AND `password`=?";
    $stmt = $mysql->connection->prepare($query);
    $stmt->bind_param("ss", $login, $hashed_password);
    $stmt->execute();
    if ($stmt->num_rows != 1) {
        echo "wrong password";
        exit;
    }
    $id = '';
    $stmt->bind_result($id);
    $stmt->fetch();
    $_SESSION['id'] = $id;
    $_SESSION['login'] = $login;
} else {
    echo "login or/and password are empty";
    exit;
}

isset($_SERVER['HTTP_REFERER']) ? header("Location: {$_SERVER['HTTP_REFERER']}") : header("Location: /");