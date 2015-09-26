<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if (isset($_SESSION['id']) == 0) {
    header('Location: /error/denied.php');
    exit();
}
if ($filesn == 0 or $files == 0) {
    header('Location: /ftp/?error=1');
    exit();
}
$code = array_merge(range('a', 'z'), range('0', '9'));
$key = '';
for ($i = 0; $i < 30; $i++)
    $key .= $code[array_rand($code)];
$uploaddir = "C:/Program Files (x86)/Apache Software Foundation/Apache2.2/htdocs/upload/files/$login/";
$userfilename = mysql_real_escape_string($_FILES['userfile']['name']);
$access = mysql_real_escape_string($_POST['access']);
if ($access != 1) $access = 0;
$ext = explode(".", $userfilename);
$ext = end($ext);
$uploadfile = $uploaddir . $key . "." . $ext;
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
$files = $files - $_FILES['userfile']['size'];
$filesn = $filesn - 1;
if ($_FILES['userfile']['size'] == 0) {
    header('Location: /ftp/?error=2');
    exit();
}
if ($filesn <= 0 or $files <= 0) {
    header('Location: /ftp/?error=1');
    exit();
}
$filename = basename($uploadfile);
$uploadfile = "/upload/files/$login/$filename";
mysql_select_db("files") or die (mysql_error());
$size = $_FILES['userfile']['size'];
$key = '';
for ($i = 0; $i < 10; $i++)
    $key .= $code[array_rand($code)];
$query = "INSERT INTO files_$id(file, name, fkey, size, time, access) VALUES ('$uploadfile', '$userfilename', '$key', '$size', '$time', '$access')";
$sql = mysql_query($query) or die(mysql_error());
mysql_select_db("main") or die (mysql_error());
$query = "UPDATE `users` SET `files`='$files' WHERE id='$id'";
$sql = mysql_query($query) or die(mysql_error());
$query = "UPDATE `users` SET `filesn`='$filesn' WHERE id='$id'";
$sql = mysql_query($query) or die(mysql_error());
mysql_select_db("files") or die (mysql_error());
$query = "SELECT id FROM `files_$id` WHERE `fkey`='$key' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$file = mysql_fetch_assoc($sql);
include('../engine/main_stat.php');
header("Location: /ftp/?ok=1&file_id={$file['id']}&id=$id&key=$key");
?>