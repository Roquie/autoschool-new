-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 28, 2014 at 11:25 AM
-- Server version: 5.5.33
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mpt_auto`
--

-- --------------------------------------------------------

--
-- Table structure for table `Administrators`
--

CREATE TABLE `Administrators` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `family_name` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Contracts`
--

CREATE TABLE `Contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `famil` varchar(255) NOT NULL,
  `imya` varchar(255) NOT NULL,
  `ot4estvo` varchar(255) NOT NULL,
  `adres_reg_po_pasporty` varchar(255) NOT NULL,
  `pasport_seriya` varchar(255) NOT NULL,
  `pasport_nomer` varchar(255) NOT NULL,
  `pasport_kem_vydan` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Educations`
--

CREATE TABLE `Educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `obrazovanie` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Educations`
--

INSERT INTO `Educations` (`id`, `obrazovanie`) VALUES
(1, 'Высшее'),
(2, 'Среднее');

-- --------------------------------------------------------

--
-- Table structure for table `Files`
--

CREATE TABLE `Files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `path` varchar(500) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Files`
--

INSERT INTO `Files` (`id`, `filename`, `desc`, `path`) VALUES
(1, 'Dogovor.doc', 'Файл договора', 'output_blanks/other_files/'),
(2, 'Zaivlenie.doc', 'Файл заявления', 'output_blanks/other_files/f'),
(3, 'kvitanciya.doc', 'Файл квитанции', 'output_blanks/other_files/'),
(4, 'license-0000540.pdf', 'Файл лицензии', 'output_blanks/other_files/'),
(5, 'dogovor.docx', 'Шаблон для договора', 'templates/contract/'),
(6, 'template.docx', 'Шаблон для заявления', 'templates/zayavlenie/'),
(7, 'ticket.docx', 'Шаблон для квитанции', 'templates/ticket/');

-- --------------------------------------------------------

--
-- Table structure for table `Groups`
--

CREATE TABLE `Groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT '0',
  `title_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Nationality`
--

CREATE TABLE `Nationality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grajdanstvo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Nationality`
--

INSERT INTO `Nationality` (`id`, `grajdanstvo`) VALUES
(1, 'РФ'),
(2, 'РБ');

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE `News` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `message` varchar(900) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `News`
--

INSERT INTO `News` (`id`, `title`, `message`, `group_id`) VALUES
(1, 'Заголовок для группы1, номер 1', 'Много всяких новостей для группы1', 1),
(2, 'Заголовок для группы2, номер 1', 'группа2 говорит Бла блаб лаб лабалабалабалабалабл ', 2),
(3, 'Заголовок для группы1, номер 2', 'asdasdasdasdasdasdasdasdasdasdasdasd fja9sfywn m ihfasfhw gsgf8safg as fas fisghfwgfsh shfg8fwfg', 1),
(4, 'Заголовок для группы1, номер 3', 'ыдл о арцр алар8а л ыврыр нг ролыар 0ацг ываы щышагн ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.'),
(3, 'user', '');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE `Settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(900) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Settings`
--

INSERT INTO `Settings` (`id`, `name`, `value`) VALUES
(1, 'smtp', '0'),
(2, 'admin_avatar', 'img/admin_avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `Statements`
--

CREATE TABLE `Statements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `famil` varchar(255) NOT NULL,
  `imya` varchar(255) NOT NULL,
  `ot4estvo` varchar(255) NOT NULL,
  `data_rojdeniya` varchar(255) NOT NULL,
  `mesto_rojdeniya` varchar(255) NOT NULL,
  `adres_reg_po_pasporty` varchar(255) NOT NULL,
  `vrem_reg` varchar(255) NOT NULL,
  `pasport_seriya` varchar(255) NOT NULL,
  `pasport_nomer` varchar(255) NOT NULL,
  `pasport_data_vyda4i` varchar(255) NOT NULL,
  `pasport_kem_vydan` varchar(255) NOT NULL,
  `mob_tel` varchar(255) NOT NULL,
  `dom_tel` varchar(255) NOT NULL,
  `mesto_raboty` varchar(255) NOT NULL,
  `about` varchar(255) NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `education_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Statements`
--

INSERT INTO `Statements` (`id`, `user_id`, `famil`, `imya`, `ot4estvo`, `data_rojdeniya`, `mesto_rojdeniya`, `adres_reg_po_pasporty`, `vrem_reg`, `pasport_seriya`, `pasport_nomer`, `pasport_data_vyda4i`, `pasport_kem_vydan`, `mob_tel`, `dom_tel`, `mesto_raboty`, `about`, `nationality_id`, `education_id`) VALUES
(1, 70, 'Мельников', 'Виктор', 'Игоревич', '', '', '', '', '', '', '', '', '8 (925) 199-04-81', '', '', '', 0, 0),
(2, 1, 'Мельников', 'Виктор', 'Игоревич', '', '', '', '', '', '', '', '', '8 (925) 199-04-81', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `email`, `password`, `photo`, `logins`, `last_login`, `group_id`, `status`) VALUES
(1, 'vik.melnikov@gmail.com', 'c6e181e72f2cf4083b6ba1da892a4ebf06d55fbda6814eabe1c691c48dcfe171', 'img/photo.jpg', 0, 1393572301, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(32) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
