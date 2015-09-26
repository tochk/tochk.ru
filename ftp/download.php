<?php
session_start();
include('../engine/timer_init.php');
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
$file_id = mysql_real_escape_string($_GET['file_id']);
$uploader = mysql_real_escape_string($_GET['id']);
mysql_select_db("files") or die (mysql_error());
$query = "SELECT * FROM `files_$uploader` WHERE `id`='$file_id' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$file = mysql_fetch_assoc($sql);
$dl_num = $file['dl_num'];
if ($_GET['key'] == $file['fkey']) {
    if (($_SESSION['id'] != $_GET['id']) and ($file['access'] != true)) {
        print "Доступ запрещён!";
        include('../engine/main_stat.php');
        exit();
    } else {
        $dl_file = "C:/Program Files (x86)/Apache Software Foundation/Apache2.2/htdocs" . $file['file'];
        if (file_exists($dl_file)) {
            $query = "UPDATE `files_$uploader` SET `time2`='$time' WHERE `dl_num`='$dl_num' LIMIT 1";
            $sql = mysql_query($query) or die(mysql_error());
            if (ob_get_level()) {
                ob_end_clean();
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $file['name']);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($dl_file));
            readfile($dl_file);
        }
        include('../engine/main_stat.php');
    }
} else {
    print "Неверная ссылка!";
    include('../engine/main_stat.php');
}
?>