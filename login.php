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
$logs = new Logs();
$data = new Data();

if ($_GET['logout'] == 1) {
    unset($_SESSION['id']);
    unset($_SESSION['login']);
    header("Location: /");
    exit;
}

$login = isset($_POST["login"]) ? $_POST["login"] : null;
$password = isset($_POST["password"]) ? $_POST["password"] : null;

if ($login && $password) {
    if ($salt = $user->getSaltFromDb($mysql, $login)) {
        if ($id = $user->checkPassword($mysql, $login, $password, $salt)) {
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $login;
        } else {
            echo "wrong password";
            exit;
        }
    } else {
        echo "wrong login";
        exit;
    }
} else {
    echo "login or/and password are empty";
    exit;
}

isset($_SERVER['HTTP_REFERER']) ? header("Location: {$_SERVER['HTTP_REFERER']}") : header("Location: /");