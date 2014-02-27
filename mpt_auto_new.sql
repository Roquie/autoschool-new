-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2014 at 01:36 PM
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=62 ;

--
-- Dumping data for table `Administrators`
--

INSERT INTO `Administrators` (`id`, `email`, `datetime`) VALUES
(7, 'roquie0@gmail.com', '2013-10-01 23:12:24'),
(24, 'vik.melnikov@gmail.com', '2013-10-14 19:45:19'),
(28, 'asdaaasdasd@asdas.ads', '2013-11-30 19:29:16'),
(44, '7@asdas.ads', '2013-11-30 19:30:25'),
(45, '721@asdas.ads', '2013-11-30 19:30:28'),
(46, '1@asdas.ads', '2013-11-30 19:30:30'),
(53, 'asaaddasd@sada.as', '2014-01-09 11:45:48'),
(58, 'example@mail.com', '2014-02-01 10:43:14'),
(61, 'm.ivanov@altegro.ru', '2014-02-21 07:58:13');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `Contracts`
--

INSERT INTO `Contracts` (`id`, `user_id`, `famil`, `imya`, `ot4estvo`, `adres_reg_po_pasporty`, `pasport_seriya`, `pasport_nomer`, `pasport_kem_vydan`, `phone`) VALUES
(27, 21, 'Петрова', 'Анастасия', 'Агафьевна', 'г. Москва, ул. Петросяна, д.13, к.9', '4382', '20934820', 'ОВД Г.КАЗАНИ 2', '+79261195550'),
(39, 32, 'Мельников', 'Виктор', 'Игоревич', 'Адрес регистрации по паспорту', '123123', '11231231', 'ОВД ЧЕРТАНОВО', '8 (312) 312-31-21'),
(41, 34, 'ыФВ', 'фыв', 'фывф', 'фывфыв', '31ц', '3цу', 'фвывфыв', '8 (344) 343-43-43'),
(45, 38, 'asdasad', 'asddd', 'sdadas', 'asdasdasd', '1323123', '12313', 'eqweqw', '8 (123) 123-13-12'),
(46, 39, 'asdasasd', 'asadsd', 'asdasdasd', 'asdsds', '123123', '123123', 'qweqwe', '8 (123) 123-12-31');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `Groups`
--

INSERT INTO `Groups` (`id`, `name`) VALUES
(1, 'Группа1'),
(2, 'Группа2'),
(7, 'Группа3'),
(8, 'Группа4'),
(9, 'Группа5'),
(10, 'Группа6'),
(11, 'Группа6'),
(12, 'Группа7'),
(13, 'Группа8'),
(14, 'Группа9'),
(16, 'Группа10'),
(17, 'Группа11'),
(18, 'фыв'),
(19, '123');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`id`, `user_id`, `admin`, `message`, `is_read`, `title_id`, `datetime`) VALUES
(13, 21, 0, 'sdfsdf', 0, 13, '2013-11-30 13:09:22'),
(14, 21, 0, 'lkasdlkasdlkasd', 0, 13, '2013-11-30 13:09:29'),
(17, 21, 0, 'sdfsdf', 0, 17, '2013-11-30 13:15:05'),
(18, 21, 0, 'zxczx', 0, 18, '2013-11-30 13:18:56'),
(19, 21, 0, 'alert(1111)', 0, 20, '2013-11-30 13:19:25'),
(20, 21, 0, 'ываываы', 0, 20, '2013-11-30 13:26:45'),
(21, 21, 0, 'ывывывыыввы', 0, 21, '2013-11-30 13:26:51');

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
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(52, 3),
(53, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `Statements`
--

INSERT INTO `Statements` (`id`, `user_id`, `famil`, `imya`, `ot4estvo`, `data_rojdeniya`, `mesto_rojdeniya`, `adres_reg_po_pasporty`, `vrem_reg`, `pasport_seriya`, `pasport_nomer`, `pasport_data_vyda4i`, `pasport_kem_vydan`, `mob_tel`, `dom_tel`, `mesto_raboty`, `about`, `nationality_id`, `education_id`) VALUES
(27, 21, 'Труляля', 'Hидрwewr', 'Сидорович', '01.01.1974', 'г. Москва, РФ', 'г. Москва, ул. Петросяна, д.13, к.9', 'г. Казань, ул. Матрёшкина, д.77', '2937', '3453890', '20.01.1989', 'ОВД Г.КАЗАНИ', '+79091234567', '10238102487', 'Гендиректор ООО АэроТрансКарго', 'Интернет', 1, 1),
(73, 32, 'Мельников', 'Виктор', 'Игорев', '08.10.1980', 'Москва', 'Адрес регистрации по паспорту', '', '123123', '11231231', '02.10.2013', 'ОВД ЧЕРТАНОВО', '8 (312) 312-31-21', '8 (123) 123-12-31', 'Фриланс', 'Интернет', 1, 1),
(75, 34, 'ыФВ', 'фыв', 'фывф', '06.12.1979', 'фывфыв', 'фывфыв', '', '31ц', '3цу', '02.12.2013', 'фвывфыв', '8 (344) 343-43-43', '', '4234', 'Интернет', 1, 1),
(79, 38, 'asdasadas', 'asddddasdasd', 'sdadas', '04.01.1962', 'asdasd', 'asdasdasd', '', '1323123', '12313', '03.01.2014', 'eqweqw', '8 (123) 123-13-12', '8 (131) 231-23-12', 'wdasdsa', 'Интернет', 1, 1),
(80, 39, 'asdasasd', 'asadsd', 'asdasdasd', '03.01.1962', 'asdsasd', 'asdsds', '', '123123', '123123', '02.01.2014', 'qweqwe', '8 (123) 123-12-31', '8 (123) 123-12-12', '1231212313', 'Интернет', 1, 1),
(81, 57, 'qwewq', 'qweq', 'dasd', '', '', '', '', '', '', '', '', '31231312312', '', '', '', 0, 0),
(82, 59, 'qwqw', 'asdqeq', 'as', '', '', '', '', '', '', '', '', 'asdqe', '', '', '', 0, 0),
(83, 60, 'asd', 'asd', 'asd', '', '', '', '', '', '', '', '', 'asda', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Titles`
--

CREATE TABLE `Titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `Titles`
--

INSERT INTO `Titles` (`id`, `title`, `user_id`) VALUES
(12, 'df', 21),
(13, 'df', 21),
(16, 'dsf', 21),
(17, 'dsf', 21),
(18, 'zczc', 21),
(19, 'zczc', 21),
(20, 'zczc', 21),
(21, 'выыв', 21);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `email`, `password`, `photo`, `logins`, `last_login`, `group_id`, `status`) VALUES
(21, 'roquie01@gmail.com', 'd7d08d38a9afca0ddce06ac13992447f949fa6cc1d801ed2c88aa4f385fc21c9', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAAADo/7_ZOUfX0-gk/photo.jpg', 0, 0, 1, 3),
(32, 'vik.melnikov@gmail.com', 'd7d08d38a9afca0ddce06ac13992447f949fa6cc1d801ed2c88aa4f385fc21c9', 'https://lh5.googleusercontent.com/-sUhzn4o5Wc4/AAAAAAAAAAI/AAAAAAAAFuI/3UlHj3ZH2NA/photo.jpg', 0, 0, 0, 3),
(34, 'roquie1@list.ru', '0f15db87e74db9659e212f6a291d38bd5bd2d52ee301632bbf86859ffc7f512f', 'http://avt.appsmail.ru/list/roquie/_avatarbig', 0, 0, 0, 3),
(38, 'roquie@list.ru', 'b9b62acbe6417941f5582fb16c730abf1d43033799f5144a78833d3b3926ac04', 'http://avt.appsmail.ru/list/roquie/_avatarbig', 0, 0, 1, 3),
(39, 'asdaaasdasd@asdas.ads', 'd685011e0c0a3f57744c9f1cc7d2d0be43a1e208db7c5295b957ca13fb917c47', 'img/photo.jpg', 0, 0, 0, 0),
(40, 'roquie02@gmail.com', '5F7rY3Bn', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 0, 0, 0),
(41, 'roquie03@gmail.com', '9tsxdgY5', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 0, 0, 0),
(42, 'roquie04@gmail.com', 'nm3ip9kE', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 0, 0, 0),
(43, 'roquie05@gmail.com', 'r0XnJeYp', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 0, 0, 0),
(44, 'roquie06@gmail.com', '25TG3osA', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 0, 0, 0),
(45, 'roquie07@gmail.com', '25EgFhKY', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 0, 0, 0),
(46, 'roquie08@gmail.com', 'PGSi4sZx', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393417630, 0, 0),
(47, 'roquie09@gmail.com', 'yeGlRxC8', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393417754, 0, 0),
(48, 'roquie010@gmail.com', '90c3a20d1b6fedd8754754b106e7cbe19a3f89b1120852c492cb1a5ad6d2a6c2', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393417916, 0, 0),
(49, 'roquie011@gmail.com', 'b783b4a9803723df470005cd0b685f25b67f26338011bd8a11b9352c3057e60b', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393418117, 0, 0),
(50, 'roquie012@gmail.com', '4811afdb9c11f1247f591eadfddf6b071295e2ba067fb539286fa67cd85fee96', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393418714, 0, 0),
(51, 'roquie033@gmail.com', '8d9e360ac9bbf3acf53ddf5d8a8ccd180d0d489c8a389db20b80f32efec8294f', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393418744, 0, 0),
(52, 'roquie034@gmail.com', '7d69422f4ff8f39536b2cb05b7a8ec69fdfce9cae62c3d6dce824cad65ff355c', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393418902, 0, 0),
(53, 'roquie035@gmail.com', '04f6e71644436d89c58663b7756623c6dd4f6c925db954b56ce3ed020ff26fc0', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393419952, 0, 0),
(54, 'm.ivanov@altegro.ru', 'a33eb96b7e3f45df8eda232a09e9d526450e53778f1589a4f648e4fa3a09f9c7', 'img/photo.jpg', 0, 0, 0, 0),
(57, 'roquie099@gmail.com', '713df0f5f6d11418f9a31b9eb68f57f8e7c98e4dfb5e8d33775bcd01f41639f3', 'img/photo.jpg', 0, 1393440898, 0, 0),
(58, 'roquie0@gmail.com', '024590609ac0d13c0d734a68a34aba2cde82188f414c15ca161c4ef209197fe2', 'https://lh5.googleusercontent.com/-8tZI2QQx310/AAAAAAAAAAI/AAAAAAAALk4/PHtvJOM_iDo/photo.jpg', 0, 1393448620, 0, 0),
(59, 'asd@asd.aa', '57f9cc7251ad05e75673bdc4a93414ab2f5bf2726c3d84edb06de3502214f90b', 'img/photo.jpg', 0, 1393449828, 0, 0),
(60, 'example@mail.com', '4d95d8c6fa783ee97bc6709b1ac1c5c1e8e1aaa7a2cf741254babd6832856ee5', 'img/photo.jpg', 0, 1393450334, 0, 0);

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
