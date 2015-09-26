<?php
/**
 * tochk.ru CMS installer for v1.01.00
 * by bezumnytochk
 * 22.08.2014
 **/
include('./engine/classes_main.php');
$main = new tochkru_main();
$main->installer_mysql_conn();
$query = "CREATE DATABASE tochkru_main CHARACTER SET utf8;";
$sql = mysql_query($query) or die(mysql_error());
mysql_select_db("tochkru_main") or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_config` (
  `id` int(1) NOT NULL DEFAULT '0',
  `closed` int(1) NOT NULL DEFAULT '0',
  `update` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$sql = mysql_query($query) or die(mysql_error());
$query = "INSERT INTO `tochkru_config` (`id`, `closed`, `update`) VALUES (1, 0, 'Технические работы');";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_stat` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `day` int(3) NOT NULL DEFAULT '1',
  `mou` int(3) NOT NULL DEFAULT '1',
  `year` int(5) NOT NULL DEFAULT '1970',
  `hosts` int(20) NOT NULL DEFAULT '1',
  `hits` int(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_temp_stat` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL,
  `hits` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `comment` text NOT NULL,
  `url` text NOT NULL,
  `img_url` text NOT NULL,
  `type` varchar(5) NOT NULL,
  `pr` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
$sql = mysql_query($query) or die(mysql_error());
$query = "INSERT INTO `tochkru_index` (`id`, `time`, `name`, `comment`, `url`, `img_url`, `type`, `pr`) VALUES
(1, 1400000000, 'Файлхостинг', 'Доступен только для зарегестрированных пользователей', '/ftp/', '', 'SR', 500),
(2, 1400000000, 'Исходный код на GitHub', 'Сайт работает на tochk.ru CMS', '/ftp/', '', 'PR', 1000);";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_stat_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(20) DEFAULT NULL,
  `ip` text NOT NULL,
  `page` text NOT NULL,
  `ms_conn` float DEFAULT NULL,
  `ms_query` float DEFAULT NULL,
  `history` float DEFAULT NULL,
  `end` float DEFAULT NULL,
  `reff` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$sql = mysql_query($query) or die(mysql_error());
?>