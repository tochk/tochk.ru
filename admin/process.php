<?php
session_start();
$title = "Панель управления сайтом";
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function __autoload($class_name)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
}

$main = new page_init();
$main->std_page_init();
function addBlogPost($theme, $text, $preview, $authorId) {

}

function editBlogPost($theme, $text, $preview, $postId) {

}

function addProject($name, $text, $coder, $designer, $url) {

}

function editProject($name, $text, $coder, $designer, $url) {

}

function addToPortfolio($name, $text, $coder, $designer, $url) {

}

function editPortfolio($name, $text, $coder, $designer, $url) {

}
$main->timer_save();