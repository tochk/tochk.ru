<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

if (isset($_SESSION['id'])) {
    header('Location: /');
    exit();
}
$main = new page_init();
$main->std_page_init();
$login = mysql_real_escape_string($_POST['login']);
$password = mysql_real_escape_string($_POST['password']);
$password2 = mysql_real_escape_string($_POST['password2']);
$email = mysql_real_escape_string($_POST['email']);
if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $_SESSION['reg_err7'] = 1;
    $flag = 1;
}
if (strlen($login) < 5) {
    $_SESSION['reg_err2'] = 1;
    $flag = 1;
}
if (strlen($password) < 5) {
    $_SESSION['reg_err3'] = 1;
    $flag = 1;
}
$query = "SELECT `id` FROM `users` WHERE `email`='$email' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($sql) == 1) {
    $_SESSION['reg_err6'] = 1;
    $flag = 1;
}
$query = "SELECT `id` FROM `users` WHERE `login`='$login' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
if (mysql_num_rows($sql) == 1) {
    $_SESSION['reg_err4'] = 1;
    $flag = 1;
}
if ($password != $password2) {
    $_SESSION['reg_err5'] = 1;
    $flag = 1;
}
if ($flag == 1) {
    header('Location: /register/');
    exit();
}
$salt = '';
$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
$counter = strlen($pattern) - 1;
for ($i = 0; $i < 3; $i++) {
    $salt .= $pattern{rand(0, $counter)};
}
$hashed_password = hash('sha256', hash('sha256', $password) . $salt);
$query = "INSERT INTO `users` SET `login`='$login', `email`='$email', `password`='$hashed_password', `salt`='$salt'";
$sql = mysql_query($query) or die(mysql_error());
$query = "SELECT `id` FROM `users` WHERE `login`='$login' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$query = "CREATE TABLE `logs`.`{$row['id']}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(32) NOT NULL DEFAULT '0',
  `result` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
$sql = mysql_query($query) or die(mysql_error());
$_SESSION['reg_ok'] = 1;
$main->timer_save();
header('Location: /');
