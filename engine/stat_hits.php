<?php
session_start();
include('../engine/mysql_connect.php');
include('../engine/mysql_main_query.php');
include('../engine/history.php');
if ($admin == 0) {
    header('Location: /');
    exit();
}
include 'pChart/pData.class';
include 'pChart/pCache.class';
include 'pChart/pChart.class';
$myData = new pData();
$result = mysql_query("SELECT * FROM days ORDER BY id DESC");
$stat = mysql_fetch_array($result, MYSQL_ASSOC);
for ($i = 0; $i <= 30; $i++) {
    $row[30 - $i]['day'] = $stat['day'];
    $row[30 - $i]['hits'] = $stat['hits'];
    $stat = mysql_fetch_array($result, MYSQL_ASSOC);
}
$lim = 0;
while ($lim <= 30) {
    $myData->AddPoint($row[$lim]["day"], "day");
    $myData->AddPoint($row[$lim]["hits"], "hits");
    $lim++;
}
$myData->SetAbsciseLabelSerie("day");
$myData->AddSerie("hits");
$myData->SetSerieName(mb_convert_encoding("Hits", 'utf-8', 'windows-1251'), "hits");
$graph = new pChart(1000, 500);
$graph->setFontProperties("Fonts/tahoma.ttf", 10);
$graph->setGraphArea(85, 30, 950, 400);
$graph->drawFilledRoundedRectangle(7, 7, 993, 493, 5, 240, 240, 240);
$graph->drawRoundedRectangle(5, 5, 995, 495, 5, 230, 230, 230);
$graph->drawGraphArea(255, 255, 255, TRUE);
$graph->drawScale($myData->GetData(), $myData->GetDataDescription(),
    SCALE_NORMAL, 150, 150, 150, true, 0, 2);
$graph->drawGrid(4, TRUE, 230, 230, 230, 50);
$graph->drawLineGraph($myData->GetData(), $myData->GetDataDescription());
$graph->drawPlotGraph($myData->GetData(), $myData->GetDataDescription(), 3, 2, 255, 255, 255);
$graph->setFontProperties("Fonts/tahoma.ttf", 10);
$graph->drawLegend(90, 35, $myData->GetDataDescription(), 255, 255, 255);
$graph->setFontProperties("Fonts/tahoma.ttf", 10);
$graph->drawTitle(480, 22, mb_convert_encoding("��������", 'utf-8', 'windows-1251'),
    50, 50, 50, -1, -1, true);
$graph->Stroke();
?>