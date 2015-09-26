<?php
session_start();
include('./engine/timer_init.php');
include('./engine/mysql_connect.php');
include('./engine/history.php');
if ($_GET['logout'] == 1) {
    unset($_SESSION['id']);
    unset($_SESSION['login']);
    include('./engine/main_stat.php');
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
        $salt = $row['salt'];
        $password = hash('sha256', md5(md5($password) . $salt));
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
}
include('./engine/main_stat.php');
header("Location: {$_SERVER['HTTP_REFERER']}");
?>