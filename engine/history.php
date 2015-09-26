<?php
$stat_time = time();
$stat_day = date(d);
$stat_month = date(n);
$stat_year = date(Y);
$stat_ip = 0;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $stat_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $stat_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $stat_ip = $_SERVER['REMOTE_ADDR'];
}
$stat_ip = mysql_real_escape_string($stat_ip);
$days_query = "SELECT * FROM `days` WHERE `day`='$stat_day' AND `mou`='$stat_month' AND `year`='$stat_year' LIMIT 1";
$days_sql = mysql_query($days_query) or die(mysql_error());
$days_arr = mysql_fetch_assoc($days_sql);
$days_num = mysql_num_rows($days_sql);
if ($days_num != 1) {
    $query = "INSERT INTO `days` SET `day`='$stat_day', `mou`='$stat_month' ,`year`='$stat_year', `hits` = '1', hosts = '1'";
    $sql = mysql_query($query) or die(mysql_error());
    $query = "DROP table history2";
    $sql = mysql_query($query) or die(mysql_error());
    $query = "CREATE TABLE IF NOT EXISTS `history2` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ip` longtext COLLATE utf8_unicode_ci NOT NULL,
    `time` int(11) NOT NULL,
    `hits` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    $sql = mysql_query($query) or die(mysql_error());
    $query = "INSERT INTO `history2` SET `time`='$stat_time', `hits`=1, `ip`='$stat_ip'";
    $sql = mysql_query($query) or die(mysql_error());
} else {
    $days_arr['hits']++;
    $history2_query = "SELECT * FROM `history2` WHERE `ip`='$stat_ip' LIMIT 1";
    $history2_sql = mysql_query($history2_query) or die(mysql_error());
    $history2_arr = mysql_fetch_assoc($history2_sql);
    $history2_num = mysql_num_rows($history2_sql);
    if ($history2_num == 0) {
        $days_arr['hosts']++;
        $query = "INSERT INTO `history2` SET `time`='$stat_time', `hits`=1, `ip`='$stat_ip'";
        $sql = mysql_query($query) or die(mysql_error());
    } else {
        $history2_arr['hits']++;
        $query = "UPDATE history2 SET `hits`='{$history2_arr['hits']}' WHERE `ip`='$stat_ip' LIMIT 1";
        $sql = mysql_query($query) or die(mysql_error());
    }
    $query = "UPDATE days SET `hits`='{$days_arr['hits']}', `hosts`='{$days_arr['hosts']}' WHERE `day`='$stat_day' AND `mou`='$stat_month' AND `year`='$stat_year' LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());
}
$temp = microtime();
$temp = explode(" ", $temp);
$timer["history"] = $temp[1] + $temp[0];
?>