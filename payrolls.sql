-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 10 2019 г., 01:26
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `epam`
--

-- --------------------------------------------------------

--
-- Структура таблицы `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `department` varchar(128) NOT NULL,
  `amount` int(11) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payrolls`
--

INSERT INTO `payrolls` (`id`, `name`, `department`, `amount`, `salary`) VALUES
(11, 'Богдан', 'Mobile phones', 6, 450),
(12, 'Monika', 'Mobile phones', 100, 7500),
(14, 'Nick', 'Mobile phones', 14, 1050),
(15, 'Lika', 'Computers', 10, 2250),
(16, 'Aron', 'TV sets', 83, 12450),
(17, 'Aron', 'TV sets', 2, 300),
(18, 'Chris', 'Computers', 5, 1125),
(19, 'Emma', 'Mobile phones', 11, 825),
(21, 'Jacob', 'Computers', 4, 900),
(22, 'Daniel', 'Mobile phones', 28, 2100),
(23, 'Madison', 'TV sets', 30, 4500),
(34, 'Aron', 'Mobile phones', 12, 900),
(43, 'Skylar', 'Computers', 3, 675);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
