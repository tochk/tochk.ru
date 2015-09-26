CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL DEFAULT '0',
  `closed` varchar(32) NOT NULL DEFAULT '0',
  `update` varchar(32) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`id`, `closed`, `update`) VALUES
(1, '0', '02:00');


CREATE TABLE IF NOT EXISTS `days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` int(11) NOT NULL,
  `hosts` int(11) NOT NULL DEFAULT '1',
  `hits` int(11) NOT NULL DEFAULT '0',
  `mou` int(11) NOT NULL DEFAULT '0',
  `year` int(11) NOT NULL DEFAULT '1970',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `history2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `indexpr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `comment` text NOT NULL,
  `url` text NOT NULL,
  `img_url` text NOT NULL,
  `type` varchar(5) NOT NULL,
  `pr` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `indexpr`
--

INSERT INTO `indexpr` (`id`, `time`, `name`, `comment`, `url`, `img_url`, `type`, `pr`) VALUES
(1, 1400000000, 'Файлхостинг', 'Доступен только для зарегестрированных пользователей.', '/ftp/', '', 'SR', 350);


CREATE TABLE IF NOT EXISTS `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invite` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `sandbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `comment` text NOT NULL,
  `url` text NOT NULL,
  `img_url` text NOT NULL,
  `type` varchar(5) NOT NULL,
  `pr` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `stat` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '0',
  `email` varchar(32) NOT NULL DEFAULT '0',
  `comment` longtext NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `project` text NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL DEFAULT '0',
  `email` varchar(32) NOT NULL DEFAULT '0',
  `password` varchar(100) NOT NULL DEFAULT '0',
  `salt` varchar(32) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL DEFAULT '0',
  `files` bigint(32) NOT NULL DEFAULT '1073741824',
  `filesn` int(32) NOT NULL DEFAULT '1000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



