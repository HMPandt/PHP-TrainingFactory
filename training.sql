-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 07 jun 2023 om 14:32
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230524071757', '2023-05-24 09:54:17', 123),
('DoctrineMigrations\\Version20230524073712', '2023-05-24 09:54:17', 19),
('DoctrineMigrations\\Version20230524075140', '2023-05-24 09:53:28', 45),
('DoctrineMigrations\\Version20230524075502', '2023-05-24 09:55:06', 15),
('DoctrineMigrations\\Version20230524080715', '2023-05-24 10:07:19', 22),
('DoctrineMigrations\\Version20230524094227', '2023-05-24 11:42:33', 39),
('DoctrineMigrations\\Version20230524094828', '2023-05-24 11:48:31', 182),
('DoctrineMigrations\\Version20230524095334', '2023-05-24 11:53:37', 144),
('DoctrineMigrations\\Version20230524095633', '2023-05-24 11:56:37', 308);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_persons` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  `instructeur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `lesson`
--

INSERT INTO `lesson` (`id`, `time`, `date`, `location`, `max_persons`, `training_id`, `instructeur_id`) VALUES
(2, '16:00:00', '2018-01-01', 'location 1', 66, 1, NULL),
(4, '13:00:00', '2018-01-01', 'location 1', 12, 3, 7),
(5, '10:00:00', '2018-01-01', 'location 1', 53, 2, 7),
(6, '18:00:00', '2027-01-01', 'location 1', 122, 4, 7),
(7, '16:00:00', '2018-01-01', 'location 1', 43, 5, 7);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `payment` bigint(20) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `registration`
--

INSERT INTO `registration` (`id`, `payment`, `member_id`, `lesson_id`) VALUES
(1, 2, 8, 2),
(2, 3, 8, 2),
(7, 1, 6, 5),
(9, 1, 8, 5),
(10, 1, 8, NULL),
(11, 1, 8, NULL),
(12, 1, 8, 4),
(13, 1, 6, NULL),
(14, 1, 6, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `extra_costs` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `training`
--

INSERT INTO `training` (`id`, `description`, `duration`, `extra_costs`, `image`, `name`) VALUES
(1, 'text text text', 70, NULL, 'bootcamp.jpg', 'Bootcamp'),
(2, 'text text text', 120, 45, 'boxing.jpeg', 'Boxing Full-course'),
(3, 'text text text', 140, NULL, 'Kickboxing.jpg', 'Kickboxing full-course'),
(4, 'text text text', 100, NULL, 'MMA.jpeg', 'Mix Martial Arts'),
(5, 'text text text', 120, NULL, 'workout1.jpeg', 'Full-on workout course');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateofbirth` date NOT NULL,
  `preprovision` int(11) NOT NULL,
  `adres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hiring_date` date NOT NULL,
  `salary` double NOT NULL,
  `social_sec_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `firstname`, `lastname`, `dateofbirth`, `preprovision`, `adres`, `city`, `hiring_date`, `salary`, `social_sec_number`) VALUES
(1, 'Mark', '[\"ROLE_USER\"]', 'password', 'mark', 'vodi', '2018-01-01', 46, '1e van der', 'den haag', '2018-01-01', 57543, 54),
(6, 'user', '[\"ROLE_USER\"]', '$2y$13$mT.0xgQ0hvoZzoAR.H8yvuaVpHUWLN4O1WhivP295NbCGid/adHYW', 'User', 'user', '2018-01-01', 12345, '213432', 'den haag', '2018-01-01', 123123, 1231),
(7, 'bobo', '[\"ROLE_INSTRUCTEUR\"]', '$2y$13$lqEPlEKY1puUxfUAPc/0POEt0.pfy67xy4tlmv7OEE9PV7Jc6Sv.y', 'bobo', 'opop', '2018-01-01', 46, '13eeeee', 'ef', '2018-01-01', 3516314, 22),
(8, 'nana', '[\"ROLE_USER\"]', '$2y$13$bsPsSrhi/1JoHL.8xyVkEe7i24WenGLw5iR0v/7m9rPKO3tqbzUkW', 'nana', 'nnnn', '2018-01-01', 353, 'egrw 3', 'den', '2018-01-01', 35135, 11111),
(9, 'lola', '[\"ROLE_ADMIN\"]', '$2y$13$JZ4PxC5e1v4hNyU.SIol5.M85PAtu2QnbzyKabxzzEiv1sU046kPq', 'lola', 'bunny', '2019-07-01', 513235, 'erdag', 'leiden', '2023-07-10', 450, 223),
(10, 'mary', '[\"ROLE_INSTRUCTEUR\"]', '$2y$13$6Ny7K89NTsy5VHLZt77CS.gSrEsbYw0BfbcMN7rUuwMS6OKS3AsvW', 'mary', 'queen', '2018-05-01', 1234567, 'erdag', 'leiden', '2024-02-01', 600, 1234);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexen voor tabel `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F87474F3BEFD98D1` (`training_id`),
  ADD KEY `IDX_F87474F325FCA809` (`instructeur_id`);

--
-- Indexen voor tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexen voor tabel `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_62A8A7A77597D3FE` (`member_id`),
  ADD KEY `IDX_62A8A7A7CDF80196` (`lesson_id`);

--
-- Indexen voor tabel `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `FK_F87474F325FCA809` FOREIGN KEY (`instructeur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F87474F3BEFD98D1` FOREIGN KEY (`training_id`) REFERENCES `training` (`id`);

--
-- Beperkingen voor tabel `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `FK_62A8A7A77597D3FE` FOREIGN KEY (`member_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_62A8A7A7CDF80196` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
