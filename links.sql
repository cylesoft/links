
CREATE DATABASE IF NOT EXISTS `linksdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `linksdb`;

CREATE TABLE `invite_codes` (
  `code_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `thecode` varchar(250) NOT NULL,
  `theemail` varchar(250) NOT NULL,
  `beenused` tinyint(1) NOT NULL DEFAULT '0',
  `tsc` int(10) unsigned NOT NULL,
  `tsu` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `login_flood_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ipaddr` varchar(64) NOT NULL,
  `attempts` int(11) NOT NULL,
  `tsc` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ipaddr` (`ipaddr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `thelinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `privacy` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `steakonions` varchar(250) NOT NULL,
  `last_activity_ts` int(10) unsigned NOT NULL,
  `tsc` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `user_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `optname` varchar(255) NOT NULL DEFAULT '',
  `optvalue` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `user_sessions` (
  `session_key` varchar(255) NOT NULL,
  `session_secret` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` int(11) NOT NULL,
  `ts` int(11) NOT NULL,
  PRIMARY KEY (`session_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
