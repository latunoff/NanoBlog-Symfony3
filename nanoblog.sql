-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 25 2017 г., 01:32
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `nanoblog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `locs`
--

CREATE TABLE IF NOT EXISTS `locs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `var` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_de` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content_en` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_de` longtext COLLATE utf8_unicode_ci NOT NULL,
  `author_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title_en`, `title_de`, `slug`, `content_en`, `content_de`, `author_name`, `author_email`, `published_at`) VALUES
(1, 'User can view blog posts', 'Benutzer können Blog-Beiträge anzeigen', 'user-can-view-blog-posts', '○ User should be able to view the list of blog posts once he’ll login with\r\nemail/password\r\n○ User should be able to open blog post page by clicking on any blog post title in\r\nthe blog posts list\r\n○ User should be able to view the list of blog posts and blog post in another\r\nlanguage (both DE and EN should be available to user)', '○ Benutzer sollten in der Lage sein, die Liste der Blog-Posts zu sehen, sobald er sich anmelden wird\r\nE-Mail Passwort\r\n○ Benutzer sollten in der Lage sein, Blog-Post-Seite zu öffnen, indem Sie auf einen beliebigen Blog-Titel in\r\ndie Blog-Posts-Liste\r\n○ Benutzer sollten in der Lage sein, die Liste der Blog-Posts und Blog-Post in einem anderen anzeigen\r\nSprache (sowohl DE als auch EN sollte dem Benutzer zur Verfügung stehen)', 'Alex', 'latunov@ok.de', '2017-09-21 11:17:17'),
(2, 'Manager can add new blog post', 'Manager kann neue Blog-Post hinzufügen', 'manager-can-add-new-blog-post', 'Manager should be able to create new blog post, by entering following fields for\r\nevery available language (EN + DE):\r\n■ Title\r\n■ Slug\r\n■ Author name\r\n■ Author email\r\n■ Post text', 'Manager sollte in der Lage sein, neue Blog-Post zu erstellen, indem Sie folgende Felder eingeben\r\njede verfügbare Sprache (EN + DE):\r\n■ Titel\r\n■ Schnecke\r\n■ Name des Autors\r\n■ E-Mail des Autors\r\n■ Text veröffentlichen', 'Alex', 'latunov@ok.de', '2017-09-21 11:17:17');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `email`, `password`, `is_active`, `token`, `roles`) VALUES
(1, 'Alex', 'Lat', 'alex', 'alex@mail.com', '$2y$13$VH39pG96J5eJHYfgU5RyLeLHRaGysXMj2Nj/xIT1T0my4eJdaHwhK', 1, 'VYq2eg4RYmwHddS2Awj-SXU2i4OPMe8MglWZFTEt3to', '["ROLE_ADMIN"]'),
(2, 'Mad', 'Max', 'max', 'max@mail.ru', '$2y$13$F7t0DHPtS79Pckm7bj48j.hElODbyg0LJHh/edeftEyKGLQe4UQJi', 1, 'Xi8vf7Ulxwa2b7DEfo5Q7Lb7mjDrzpv9j93rN9GCrmc', '["ROLE_USER"]');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
