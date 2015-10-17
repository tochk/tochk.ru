<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if (isset($_SESSION['id'])) {
    header('Location: /');
    exit();
}
/*require_once('recaptchalib.php');
$privatekey = "recaptcha_private_key";
$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
if (!$resp->is_valid) {
    $_SESSION['rcp_err'] = "<h2>Капча была введена неправильно.<br />Ошибка: " . $resp->error;
    $flag = 1;
}*/
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
$hashed_password = hash('sha256', md5(md5($password) . $salt));
$query = "INSERT INTO `users` SET `login`='$login', `email`='$email', `password`='$hashed_password', `salt`='$salt'";
$sql = mysql_query($query) or die(mysql_error());
$query = "SELECT `id` FROM `users` WHERE `login`='$login' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$id = $row['id'];
mysql_select_db("screenshots") or die (mysql_error());
$query = "CREATE TABLE `scrn_$id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  `author` varchar(32) NOT NULL DEFAULT '0',
  `server` varchar(32) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
$sql = mysql_query($query) or die(mysql_error());
mysql_select_db("files") or die (mysql_error());
$query = "CREATE TABLE `files_$id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  `name` tinytext NOT NULL,
  `fkey` tinytext NOT NULL,
  `author` varchar(32) NOT NULL DEFAULT '0',
  `server` varchar(32) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `time2` int(11) NOT NULL DEFAULT '0',
  `dl_num` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
$sql = mysql_query($query) or die(mysql_error());
mysql_select_db("logs") or die (mysql_error());
$query = "CREATE TABLE `logs_$id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(32) NOT NULL DEFAULT '0',
  `result` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
$sql = mysql_query($query) or die(mysql_error());
$_SESSION['reg_ok'] = 1;
chdir("../upload/files/");
mkdir("$login");
chdir("../images/");
mkdir("$login");
include('../engine/main_stat.php');
header('Location: /');
