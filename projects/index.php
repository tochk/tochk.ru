<?php
session_start();
$title = "Проекты";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
$content = "";
$query = "SELECT * FROM `projects` ORDER BY `id` DESC";
$result = mysql_query($query) or die(mysql_error());
$index = mysql_fetch_array($result, MYSQL_ASSOC);
while ($index) {
    if ($index['img_url'] == '') $index['img_url'] = "/design/images/logo.png";
    $content .= "<div id='block_new_sait' onclick=\"window.open('{$index['url']}', '_blank');\"> <div id='block_in_block_sait'><div id='block_in_block_sait_2'><div id='block_sait_head'>{$index['name']}</div><div id='block_sait_scrin_info'>
<div class='block_sait_scrin_1'><div class='block_sait_scrin_2'   style='background-image: url(\"{$index['img_url']}\")'></div>
<div class='block_sait_scrin_3'>{$index['comment']}</div></div></div></div></div><div id='block_sait_info'><div id='block_sait_info_2'>
<div id='sait_date' style='width: 100px'>{$index['time']}</div><div id='sait_data_about_block' style='width: 180px'><div style='width: 80px' id='sait_author'>Author<br><text_green>{$index['author']}</text_green></div>
<div style='width: 80px' id='sait_cat'>Category<br><text_green>{$index['category']}</text_green></div></div><div id='sait_right_footer'>read more</div>
</div></div></div>";
    $index = mysql_fetch_array($result, MYSQL_ASSOC);
}
//if ($main->admin == 1) $content = $content . "<h2><a href='/admin/index_create.php' style='margin: 0;'>Создать</a></h2>";
//$content = $content . "<br />"; todo:создание проектов
$main->timer_save();
$main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);