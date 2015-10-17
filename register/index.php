<?php
session_start();
$title = "Регистрация";
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
$_SESSION['rcp_err'] = "";
$content = $content . "<center><h3>
<form action='/register/query.php' method='post'>
<table>
<tr><td>E-mail:</td><td><input type='text' name='email' /></td></tr>
<tr><td>Логин:</td><td><input type='text' name='login' /></td></tr>
<tr><td>Пароль:</td><td><input type='password' name='password' /></td></tr>
<tr><td>Подтверждение пароля:</td><td><input type='password' name='password2' /></td></tr>
<tr><td><input type='submit' value=' Зарегистрироваться ' /></td></tr>
</table>
</form>
</h3></center><br />";
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . './design/html/main.php', $title);