-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 02 月 25 日 03:43
-- 服务器版本: 5.5.25a
-- PHP 版本: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ahut`
--

-- --------------------------------------------------------

--
-- 表的结构 `ahut_lesson`
--

CREATE TABLE IF NOT EXISTS `ahut_lesson` (
  `lid` smallint(10) unsigned NOT NULL AUTO_INCREMENT,
  `lessonid` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `teacherid` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `lessonname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `teachername` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1320 ;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_lessonmate`
--

CREATE TABLE IF NOT EXISTS `ahut_lessonmate` (
  `lid` smallint(6) NOT NULL,
  `xh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  KEY `lid` (`lid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_message`
--

CREATE TABLE IF NOT EXISTS `ahut_message` (
  `mid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `read` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `to_uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `from_uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `post_time` datetime NOT NULL,
  PRIMARY KEY (`mid`),
  KEY `to_uxh` (`to_uxh`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_notice`
--

CREATE TABLE IF NOT EXISTS `ahut_notice` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `subject` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL,
  `to_uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `from_uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `post_time` datetime NOT NULL,
  PRIMARY KEY (`nid`),
  KEY `to_uxh` (`to_uxh`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_post`
--

CREATE TABLE IF NOT EXISTS `ahut_post` (
  `pid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(9) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `floor` smallint(6) NOT NULL,
  `post_time` datetime NOT NULL,
  `from_client` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=210 ;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_profile`
--

CREATE TABLE IF NOT EXISTS `ahut_profile` (
  `xh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `xm` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `xb` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `xy` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `zy` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `bj` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `rx` year(4) NOT NULL,
  `registered` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`xh`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_thread`
--

CREATE TABLE IF NOT EXISTS `ahut_thread` (
  `tid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `lid` smallint(6) NOT NULL,
  `subject` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `uname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `view` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `reply` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `post_time` datetime NOT NULL,
  `lastreply_time` datetime NOT NULL,
  `lastreply_uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `lastreply_uname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `lid` (`lid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- 表的结构 `ahut_user`
--

CREATE TABLE IF NOT EXISTS `ahut_user` (
  `uid` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `uxh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `uname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bj` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `register_time` datetime NOT NULL,
  `lastlogin_time` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `signature` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `has_avatar` tinyint(1) NOT NULL DEFAULT '0',
  `unread_message` smallint(5) unsigned NOT NULL,
  `unread_notice` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `uxh` (`uxh`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- 表的结构 `lesson2013`
--

CREATE TABLE IF NOT EXISTS `lesson2013` (
  `xh` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `xm` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `lid` smallint(6) NOT NULL,
  `lessonid` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `teacherid` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `lessonname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `lessonalias` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `teachername` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `week` tinyint(4) NOT NULL,
  `time` tinyint(4) NOT NULL,
  `startweek` tinyint(4) NOT NULL,
  `endweek` tinyint(4) NOT NULL,
  `place` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `hasnew` BOOLEAN NOT NULL DEFAULT FALSE,
  KEY `xh` (`xh`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
