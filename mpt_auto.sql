-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 21 2014 г., 18:11
-- Версия сервера: 5.5.25
-- Версия PHP: 5.4.4

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

CREATE TABLE `administrators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `family_name` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned NOT NULL,
  `is_root` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `administrators`
--

INSERT INTO `administrators` (`id`, `first_name`, `family_name`, `timestamp`, `user_id`, `is_root`) VALUES
(1, 'Максим', 'Иванов', '2014-03-16 12:40:05', 4, 1),
(2, 'Виктор', 'Мельников', '2014-03-17 17:08:36', 5, 1),
(3, 'Суперпользователь', '', '2014-03-17 19:31:43', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- Структура таблицы `category_prav`
--

CREATE TABLE `category_prav` (
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

CREATE TABLE `comissioners` (
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

CREATE TABLE `comissioners_exam` (
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

CREATE TABLE `documents` (
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

CREATE TABLE `education` (
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

CREATE TABLE `exam` (
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

CREATE TABLE `files` (
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

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `data_start` date NOT NULL,
  `data_end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `category_id`, `data_start`, `data_end`) VALUES
(1, '01-14', 1, '2014-03-01', '2014-05-01');

-- --------------------------------------------------------

--
-- Структура таблицы `individual`
--

CREATE TABLE `individual` (
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
  `vrem_reg` int(10) unsigned DEFAULT '0',
  `tel` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `listener_id` (`listener_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

CREATE TABLE `lessons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `listeners`
--

CREATE TABLE `listeners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `nationality_id` int(10) unsigned DEFAULT NULL,
  `education_id` int(10) unsigned DEFAULT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `staff_id` int(10) unsigned DEFAULT NULL,
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
  `is_individual` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `nationality_id` (`nationality_id`),
  KEY `education_id` (`education_id`),
  KEY `group_id` (`group_id`),
  KEY `staff_id` (`staff_id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `listeners`
--

INSERT INTO `listeners` (`id`, `user_id`, `about`, `nationality_id`, `education_id`, `group_id`, `staff_id`, `status`, `imya`, `famil`, `otch`, `data_rojdeniya`, `mesto_rojdeniya`, `region`, `street`, `rion`, `dom`, `korpys`, `kvartira`, `nas_pynkt`, `vrem_reg`, `document_id`, `document_seriya`, `document_nomer`, `document_data_vydachi`, `document_kem_vydan`, `tel`, `mesto_raboty`, `sex`, `date_contract`, `number_contract`, `nomer_med`, `seriya_med`, `data_med`, `kem_vydana_med`, `certificate_seriya`, `certificate_nomer`, `mark_to`, `mark_pdd`, `mark_drive`, `is_individual`) VALUES
(1, 1, 'Реклама', 1, 1, 1, NULL, 3, 'Иван', 'Зайцев', 'Петрович', '2014-03-11', 'йцувфвфывфывфывы', 'Москва', 'Одесская', 'Нагатинский', '14', '1', '123', 'Москва', 0, 1, '13123', '123123123', '2012-03-20', 'шахом', '+7(926)123-12-33', 'ООО Google, inc', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(4, 4, NULL, NULL, NULL, NULL, NULL, 0, 'asdasd', 'asd', 'asdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '13123123123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(7, 8, 'студент МПТ', 1, 2, NULL, NULL, 0, 'ололошка', 'ололошка', 'ололошевич', '1991-11-05', 'Лохляндия', 'лошковский', 'лралывра', 'фыовлфылво', '25', '8', '98', 'лыловфлыв', 0, 1, '4513', '983765', '2005-12-11', 'лфыовыфвдлдыва', '89271960386', 'лыфовло', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
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

CREATE TABLE `nationality` (
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

CREATE TABLE `news` (
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

CREATE TABLE `office` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `office_staff`
--

CREATE TABLE `office_staff` (
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

CREATE TABLE `roles` (
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

CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(4, 1),
(5, 1),
(6, 1),
(8, 1),
(4, 2),
(5, 2),
(6, 2),
(1, 3),
(8, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
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

CREATE TABLE `staff` (
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

CREATE TABLE `staff_group` (
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

CREATE TABLE `timelessons` (
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

CREATE TABLE `transport` (
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

CREATE TABLE `transport_staff` (
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

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `photo` varchar(900) NOT NULL DEFAULT 'img/photo.jpg',
  `password` varchar(255) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `photo`, `password`, `logins`, `last_login`) VALUES
(1, 'roquie@list.ru', 'http://avt.appsmail.ru/list/roquie/_avatarbig', '9ce7e5eceba5ecf50f28122ff0d6693b16395872b1779ce74948bacbd7c85eca', 0, 1394971725),
(4, 'roquie0@gmail.com', 'img/photo.jpg', '52b0349785232521b41503354a388d2c35758aaa5070b93912f554dc191ce057', 0, 1394973560),
(5, 'vik.melnikov@gmail.com', 'https://lh5.googleusercontent.com/-sUhzn4o5Wc4/AAAAAAAAAAI/AAAAAAAAFuI/3UlHj3ZH2NA/photo.jpg', 'ad196435a77e35b41056902c4abd41577057032a2328cf081f763c930bdb6a4e', 0, 1395171184),
(6, 'auto@mpt.ru', 'img/admin/admin_avatar.png', 'e8539fbadac9dae0166e096ec1596d2f80250f364061cddb4b1b183bd5492f4e', 0, 1395152429),
(8, 'petrserg6@gmail.com', 'img/photo.jpg', 'e7df01a7940fbd2d1c58a452f786a666e931ffb67a9805adda2832cb32dfbf00', 1, 1395305511);

-- --------------------------------------------------------

--
-- Структура таблицы `user_tokens`
--

CREATE TABLE `user_tokens` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `user_id`, `user_agent`, `token`, `created`, `expires`) VALUES
(4, 5, '9f3075e158173e524a226a8d13c2dc074af02e20', 'a7c9dec30d052bf8092cc300ca29fbb9cd6ccb90', 1395078344, 1395683144),
(5, 5, '203292a79ab906c5c907872a70831da69cbb1227', '2615921e1cee225fe62400ed6683a710ba01b52c', 1395122816, 1395727616);

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
