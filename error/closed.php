<?php
session_start();
include('../engine/mysql_connect.php');
$query = "SELECT * FROM `admin` WHERE `id`='1' LIMIT 1";
$sql = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_assoc($sql);
$closed = $row['closed'];
$update = $row['update'];
if ($closed == 0) {
    header('Location: /');
    exit();
}
?>
<html>
<head>
    <title>Технические работы</title>
</head>
<body bgcolor="#badbad" text="black">
<table width="100%" height="100%">
    <tr>
        <td align="center" valign="middle">
            <h3>На сервере ведутся технические работы.<br/>
                Планируемое время завершения работ: <? echo $update; ?></h3>
            <h4>Данная страница обновляется каждую минуту.</h4>
            До обновления страницы осталось <span id='timer_inp'>60</span> секунд.
            <script type="text/javascript" src="/engine/js/close_timer.js"></script>
        </td>
    </tr>
</table>
</body>
</html>
