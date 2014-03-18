-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 19 2014 г., 00:51
-- Версия сервера: 5.1.67-community-log
-- Версия PHP: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `mpt_auto`
--

-- --------------------------------------------------------

--
-- Структура таблицы `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `family_name` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `category_prav`
--

CREATE TABLE IF NOT EXISTS `category_prav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `staff_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comissioners`
--

CREATE TABLE IF NOT EXISTS `comissioners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imya` varchar(255) NOT NULL,
  `famil` varchar(255) NOT NULL,
  `otch` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comissioners_exam`
--

CREATE TABLE IF NOT EXISTS `comissioners_exam` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comissioner_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comissioner_id` (`comissioner_id`),
  KEY `exam_id` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `documents`
--

INSERT INTO `documents` (`id`, `name`) VALUES
(1, 'Паспорт'),
(2, 'Военный билет'),
(3, 'Бумага 1'),
(4, 'Бумага 2'),
(5, 'Паспорт МОРФЛОТА РФ');

-- --------------------------------------------------------

--
-- Структура таблицы `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `education`
--

INSERT INTO `education` (`id`, `name`) VALUES
(1, 'Высшее'),
(2, 'Среднее'),
(3, 'Среднее специальное');

-- --------------------------------------------------------

--
-- Структура таблицы `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `predsedatel` varchar(255) NOT NULL,
  `sekretar` varchar(255) NOT NULL,
  `number_protocol` varchar(255) NOT NULL,
  `data_protocola` date NOT NULL,
  `deducted` int(10) unsigned NOT NULL,
  `deducted_po_neysp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `path` varchar(500) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `filename`, `desc`, `path`) VALUES
(1, 'Dogovor.doc', 'Файл договора', 'output_blanks/other_files/'),
(2, 'Zaivlenie.doc', 'Файл заявления', 'output_blanks/other_files/f'),
(3, 'kvitanciya.doc', 'Файл квитанции', 'output_blanks/other_files/'),
(4, 'license-0000540.pdf', 'Файл лицензии', 'output_blanks/other_files/'),
(5, 'dogovor.docx', 'Шаблон для договора', 'templates/contract/'),
(6, 'template.docx', 'Шаблон для заявления', 'templates/zayavlenie/'),
(7, 'ticket.docx', 'Шаблон для квитанции', 'templates/ticket/');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `data_start` date NOT NULL,
  `data_end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `individual`
--

CREATE TABLE IF NOT EXISTS `individual` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listener_id` int(10) unsigned NOT NULL,
  `imya` varchar(255) NOT NULL,
  `famil` varchar(255) NOT NULL,
  `otch` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `rion` varchar(255) NOT NULL,
  `dom` varchar(255) NOT NULL,
  `korpys` varchar(255) NOT NULL,
  `kvartira` varchar(255) NOT NULL,
  `nas_pynkt` varchar(255) NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  `document_seriya` varchar(255) NOT NULL,
  `document_nomer` varchar(255) NOT NULL,
  `document_kem_vydan` text NOT NULL,
  `document_data_vydachi` date NOT NULL,
  `vrem_reg` tinyint(1) unsigned DEFAULT '0',
  `tel` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `listener_id` (`listener_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `individual`
--

INSERT INTO `individual` (`id`, `listener_id`, `imya`, `famil`, `otch`, `region`, `street`, `rion`, `dom`, `korpys`, `kvartira`, `nas_pynkt`, `document_id`, `document_seriya`, `document_nomer`, `document_kem_vydan`, `document_data_vydachi`, `vrem_reg`, `tel`) VALUES
(3, 10, 'asd', 'aSD', 'adsaaa', 'asd', 'asd', 'asd', 'asd', '', 'asd', 'asd', 1, 'aasd', 'sad112', 'asdasaaa', '2014-03-12', 1, '12312312311');

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `listeners`
--

CREATE TABLE IF NOT EXISTS `listeners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `nationality_id` int(10) unsigned DEFAULT NULL,
  `education_id` int(10) unsigned DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `staff_id` int(10) unsigned DEFAULT NULL,
  `is_individual` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` int(10) unsigned DEFAULT '0',
  `imya` varchar(255) NOT NULL,
  `famil` varchar(255) NOT NULL,
  `otch` varchar(255) NOT NULL,
  `data_rojdeniya` date DEFAULT NULL,
  `mesto_rojdeniya` text,
  `region` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `rion` varchar(255) DEFAULT NULL,
  `dom` varchar(255) DEFAULT NULL,
  `korpys` varchar(255) DEFAULT NULL,
  `kvartira` varchar(255) DEFAULT NULL,
  `nas_pynkt` varchar(255) DEFAULT NULL,
  `vrem_reg` int(11) unsigned DEFAULT '0',
  `document_id` int(10) unsigned DEFAULT NULL,
  `document_seriya` varchar(255) DEFAULT NULL,
  `document_nomer` varchar(255) DEFAULT NULL,
  `document_data_vydachi` date DEFAULT NULL,
  `document_kem_vydan` text,
  `tel` varchar(255) DEFAULT NULL,
  `mesto_raboty` varchar(255) DEFAULT NULL,
  `sex` int(11) unsigned DEFAULT NULL,
  `date_contract` date DEFAULT NULL,
  `number_contract` varchar(255) DEFAULT NULL,
  `nomer_med` varchar(255) DEFAULT NULL,
  `seriya_med` varchar(255) DEFAULT NULL,
  `data_med` date DEFAULT NULL,
  `kem_vydana_med` varchar(255) DEFAULT NULL,
  `certificate_seriya` varchar(255) DEFAULT NULL,
  `certificate_nomer` varchar(255) DEFAULT NULL,
  `mark_to` varchar(255) DEFAULT NULL,
  `mark_pdd` varchar(255) DEFAULT NULL,
  `mark_drive` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `nationality_id` (`nationality_id`),
  KEY `education_id` (`education_id`),
  KEY `group_id` (`group_id`),
  KEY `staff_id` (`staff_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `listeners`
--

INSERT INTO `listeners` (`id`, `user_id`, `about`, `nationality_id`, `education_id`, `group_id`, `staff_id`, `is_individual`, `status`, `imya`, `famil`, `otch`, `data_rojdeniya`, `mesto_rojdeniya`, `region`, `street`, `rion`, `dom`, `korpys`, `kvartira`, `nas_pynkt`, `vrem_reg`, `document_id`, `document_seriya`, `document_nomer`, `document_data_vydachi`, `document_kem_vydan`, `tel`, `mesto_raboty`, `sex`, `date_contract`, `number_contract`, `nomer_med`, `seriya_med`, `data_med`, `kem_vydana_med`, `certificate_seriya`, `certificate_nomer`, `mark_to`, `mark_pdd`, `mark_drive`) VALUES
(10, 10, 'oooo', 1, 1, NULL, NULL, 0, 0, 'Иван', 'Зайцев', 'asdas', '2014-03-13', 'asda', 'asd', 'asdas', 'adasd', '21', '12', '12', '1qw', 1, 1, 'eq21', '12w', '2014-03-21', 'qweq', '+7(926)123-12-33', 'qwe', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, NULL, NULL, NULL, NULL, NULL, 0, 0, 'Roquie', 'Petrov', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '+1(231)311-2311', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `admin` int(11) unsigned NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `nationality`
--

CREATE TABLE IF NOT EXISTS `nationality` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `nationality`
--

INSERT INTO `nationality` (`id`, `name`) VALUES
(1, 'РФ'),
(2, 'Украина');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `office`
--

CREATE TABLE IF NOT EXISTS `office` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `office_staff`
--

CREATE TABLE IF NOT EXISTS `office_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `office_id` int(10) unsigned NOT NULL,
  `staff_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `office_id` (`office_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.'),
(3, 'user', 'User role for fucking user');

-- --------------------------------------------------------

--
-- Структура таблицы `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(10, 1),
(11, 1),
(10, 3),
(11, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(900) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'smtp', 'a:4:{s:6:"server";s:22:"sslv3://smtp.gmail.com";s:4:"port";s:3:"465";s:5:"login";s:17:"autompt@gmail.com";s:8:"password";s:15:"123qweasdzxc123";}'),
(2, 'admin_avatar', 'img/admin_avatar.png');

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imya` varchar(255) NOT NULL,
  `famil` varchar(255) NOT NULL,
  `otch` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `rion` varchar(255) NOT NULL,
  `dom` varchar(255) NOT NULL,
  `korpys` varchar(255) NOT NULL,
  `kvartira` varchar(255) NOT NULL,
  `nas_pynkt` varchar(255) NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  `document_seriya` varchar(255) NOT NULL,
  `document_nomer` varchar(255) NOT NULL,
  `document_data_vydachi` date NOT NULL,
  `document_kem_vydan` text NOT NULL,
  `sex` int(11) NOT NULL,
  `nomer_prav` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `staff_group`
--

CREATE TABLE IF NOT EXISTS `staff_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `timelessons`
--

CREATE TABLE IF NOT EXISTS `timelessons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`lesson_id`),
  KEY `lesson_id` (`lesson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `reg_number` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `doc_seriya` varchar(255) NOT NULL,
  `doc_nomer` varchar(255) NOT NULL,
  `doc_data_reg` date NOT NULL,
  `doc_place_reg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `transport_staff`
--

CREATE TABLE IF NOT EXISTS `transport_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transport_id` int(10) unsigned NOT NULL,
  `staff_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transport_id` (`transport_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `photo` varchar(900) NOT NULL DEFAULT 'img/photo.jpg',
  `password` varchar(255) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `photo`, `password`, `logins`, `last_login`) VALUES
(10, 'roquie@list.ru', 'http://avt.appsmail.ru/list/roquie/_avatarbig', '2f5c785cbb27a085ece378133f35d9358d8b2c5f8360a39f59205b39ede8902a', 2, 1395171987),
(11, 'roquie0@gmail.com', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', '6a5ab4e40a91a0bfc527032348c7a511ca58b7a3ed98ad50f4134177964efaa3', 1, 1395087188);

-- --------------------------------------------------------

--
-- Структура таблицы `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  KEY `expires` (`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `administrators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `category_prav`
--
ALTER TABLE `category_prav`
  ADD CONSTRAINT `category_prav_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_prav_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comissioners_exam`
--
ALTER TABLE `comissioners_exam`
  ADD CONSTRAINT `comissioners_exam_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comissioners_exam_ibfk_3` FOREIGN KEY (`comissioner_id`) REFERENCES `comissioners` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Ограничения внешнего ключа таблицы `individual`
--
ALTER TABLE `individual`
  ADD CONSTRAINT `individual_ibfk_1` FOREIGN KEY (`listener_id`) REFERENCES `listeners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `individual_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`);

--
-- Ограничения внешнего ключа таблицы `listeners`
--
ALTER TABLE `listeners`
  ADD CONSTRAINT `listeners_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listeners_ibfk_3` FOREIGN KEY (`nationality_id`) REFERENCES `nationality` (`id`),
  ADD CONSTRAINT `listeners_ibfk_4` FOREIGN KEY (`education_id`) REFERENCES `education` (`id`),
  ADD CONSTRAINT `listeners_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `listeners_ibfk_6` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `listeners_ibfk_7` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`);

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `office_staff`
--
ALTER TABLE `office_staff`
  ADD CONSTRAINT `office_staff_ibfk_1` FOREIGN KEY (`office_id`) REFERENCES `office` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `office_staff_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`);

--
-- Ограничения внешнего ключа таблицы `staff_group`
--
ALTER TABLE `staff_group`
  ADD CONSTRAINT `staff_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_group_ibfk_4` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `timelessons`
--
ALTER TABLE `timelessons`
  ADD CONSTRAINT `timelessons_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timelessons_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `transport_staff`
--
ALTER TABLE `transport_staff`
  ADD CONSTRAINT `transport_staff_ibfk_1` FOREIGN KEY (`transport_id`) REFERENCES `transport` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transport_staff_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
