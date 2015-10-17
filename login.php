<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
if ($_GET['logout'] == 1) {
    unset($_SESSION['id']);
    unset($_SESSION['login']);
    $main->timer_save();
    header("Location: /");
    exit();
}
if (!empty($_POST)) {
    $login = mysql_real_escape_string($_POST['login']);
    $password = mysql_real_escape_string($_POST['password']);
    $query = "SELECT `salt` FROM `users` WHERE `login`='$login' LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($sql) == 1) {
        $row = mysql_fetch_assoc($sql);
        $password = hash('sha256', hash('sha256', $password) . $row['salt']);
        $query = "SELECT `id` FROM `users` WHERE `login`='$login' AND `password`='$password' LIMIT 1";
        $sql = mysql_query($query) or die(mysql_error());
        $row = mysql_fetch_assoc($sql);
        if (mysql_num_rows($sql) == 0) {
            $_SESSION['log_err'] = 1;
            header('Location: /');
            exit();
        }
        $_SESSION['id'] = $row['id'];
        $_SESSION['login'] = $login;
    } else {
        $_SESSION['log_err'] = 1;
    }
} else {
    $_SESSION['log_err'] = 1;
}
$main->timer_save();
header("Location: {$_SERVER['HTTP_REFERER']}");