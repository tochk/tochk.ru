<?php
mysql_connect("localhost", "root", "1234") or die(mysql_error());
mysql_select_db("main") or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
header('Content-Type: text/html; charset=utf-8');
$temp = microtime();
$temp = explode(" ", $temp);
$timer["ms_conn"] = $temp[1] + $temp[0];
?>
