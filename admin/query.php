<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
if ($_GET['generate'] == 1) {
    $invite = '';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
    $counter = strlen($pattern) - 1;
    for ($i = 0; $i < 12; $i++) {
        if ($i % 4 == 3) $invite .= '-';
        $invite .= $pattern[rand(0, $counter)];
    }
    $query = "INSERT INTO `invites` SET `invite`='$invite'";
    $sql = mysql_query($query) or die(mysql_error());
}
if ($_GET['session'] == 1) {
    $name = $_POST['name'];
    $value = $_POST['value'];
    $_SESSION["$name"] = $value;
}
include('../engine/main_stat.php');
header('Location: /admin/');
?>