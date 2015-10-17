В разработке
<?php
/*
include('./engine/classes_main.php');
$main = new tochkru_main();
$main->installer_mysql_conn();
$query = "CREATE DATABASE tochkru_main CHARACTER SET utf8;";
$sql = mysql_query($query) or die(mysql_error());
mysql_select_db("tochkru_main") or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_config` (
  `id` INT(1) NOT NULL DEFAULT '0',
  `closed` INT(1) NOT NULL DEFAULT '0',
  `update` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$sql = mysql_query($query) or die(mysql_error());
$query = "INSERT INTO `tochkru_config` (`id`, `closed`, `update`) VALUES (1, 0, 'Технические работы');";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_stat` (
  `id` INT(20) NOT NULL AUTO_INCREMENT,
  `day` INT(3) NOT NULL DEFAULT '1',
  `mou` INT(3) NOT NULL DEFAULT '1',
  `year` INT(5) NOT NULL DEFAULT '1970',
  `hosts` INT(20) NOT NULL DEFAULT '1',
  `hits` INT(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_temp_stat` (
  `id` INT(20) NOT NULL AUTO_INCREMENT,
  `ip` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` INT(12) NOT NULL,
  `hits` INT(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_index` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `time` INT(11) NOT NULL DEFAULT '0',
  `name` TEXT NOT NULL,
  `comment` TEXT NOT NULL,
  `url` TEXT NOT NULL,
  `img_url` TEXT NOT NULL,
  `type` VARCHAR(5) NOT NULL,
  `pr` INT(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
$sql = mysql_query($query) or die(mysql_error());
$query = "INSERT INTO `tochkru_index` (`id`, `time`, `name`, `comment`, `url`, `img_url`, `type`, `pr`) VALUES
(1, 1400000000, 'Исходный код на GitHub', 'Сайт работает на tochk.ru CMS', '/ftp/', '', 'PR', 1000);";
$sql = mysql_query($query) or die(mysql_error());
$query = "CREATE TABLE IF NOT EXISTS `tochkru_stat_pages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `time` INT(20) DEFAULT NULL,
  `ip` TEXT NOT NULL,
  `page` TEXT NOT NULL,
  `ms_conn` FLOAT DEFAULT NULL,
  `ms_query` FLOAT DEFAULT NULL,
  `history` FLOAT DEFAULT NULL,
  `end` FLOAT DEFAULT NULL,
  `reff` LONGTEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$sql = mysql_query($query) or die(mysql_error());
*/