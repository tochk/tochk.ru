<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: /');
    exit();
}
$title = "Регистрация";
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$content = "<br /><br />";
if ($_SESSION['reg_err2'] == 1) {
    $content = $content . "<h2>Логин должен содержать больше 3х символов</h2>";
    $_SESSION['reg_err2'] = 0;
}
if ($_SESSION['reg_err3'] == 1) {
    $content = $content . "<h2>Пароль должен содержать больше 3х символов</h2>";
    $_SESSION['reg_err3'] = 0;
}
if ($_SESSION['reg_err4'] == 1) {
    $content = $content . "<h2>Логин уже занят</h2>";
    $_SESSION['reg_err4'] = 0;
}
if ($_SESSION['reg_err5'] == 1) {
    $content = $content . "<h2>Введёные пароли не совпадают</h2>";
    $_SESSION['reg_err5'] = 0;
}
if ($_SESSION['reg_err6'] == 1) {
    $content = $content . "<h2>Такой E-mail уже занят</h2>";
    $_SESSION['reg_err6'] = 0;
}
if ($_SESSION['reg_err7'] == 1) {
    $content = $content . "<h2>E-mail введён некорректно</h2>";
    $_SESSION['reg_err6'] = 0;
}
$content = $content . $_SESSION['rcp_err'];
$_SESSION['rcp_err'] = "";
$content = $content . "<center><h3>
<form action='/register/query.php' method='post'>
<table>
<tr><td>E-mail:</td><td><input type='text' name='email' /></td></tr>
<tr><td>Логин:</td><td><input type='text' name='login' /></td></tr>
<tr><td>Пароль:</td><td><input type='password' name='password' /></td></tr>
<tr><td>Подтверждение пароля:</td><td><input type='password' name='password2' /></td></tr><tr><td>";
require_once('recaptchalib.php');
$publickey = "recaptcha_public_key";
$content = $content . recaptcha_get_html($publickey);
$content = $content . "</td></tr><tr><td><input type='submit' value=' Зарегистрироваться ' /></td></tr>
</table>
</form>
</h3></center><br />";
include('../engine/main_stat.php');
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true') {
    echo $content;
    echo "<title>$title - tochk.ru</title>";
} else {
    include('../design/html/main.php');
}
?>