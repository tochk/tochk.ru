<?php
$temp = microtime();
$temp = explode(" ", $temp);
$timer["end"] = $temp[1] + $temp[0];
$ms_conn = $timer["ms_conn"] - $timer["start"];
$ms_query = $timer["ms_query"] - $timer["start"];
$history = $timer["history"] - $timer["start"];
$end = $timer["end"] - $timer["start"];
mysql_select_db("main") or die(mysql_error());
$stat_url = $_SERVER['REQUEST_URI'];
$stat_url = mysql_real_escape_string($stat_url);
$stat_reffer = $_SERVER['HTTP_REFERER'];
$stat_reffer = mysql_real_escape_string($stat_reffer);
$query = "INSERT INTO `stat` SET `time`='$stat_time', `ip`='$stat_ip', `page`='$stat_url', `ms_conn`='$ms_conn', `ms_query`='$ms_query', `history`='$history', `end`=$end, `reff`='$stat_reffer'";
$sql = mysql_query($query) or die(mysql_error());
?>