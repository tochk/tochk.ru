<?php
$temp = microtime();
$temp = explode(" ", $temp);
$timer["start"] = $temp[1] + $temp[0];
$timer["ms_conn"] = $temp[1] + $temp[0];
$timer["ms_query"] = $temp[1] + $temp[0];
$timer["history"] = $temp[1] + $temp[0];
$timer["end"] = $temp[1] + $temp[0];
?>