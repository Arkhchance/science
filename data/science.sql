-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 29, 2019 at 04:37 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `science`
--
CREATE DATABASE IF NOT EXISTS `science` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `science`;

-- --------------------------------------------------------

--
-- Table structure for table `domaine`
--

CREATE TABLE `domaine` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domaine`
--

INSERT INTO `domaine` (`id`, `nom`, `description`) VALUES
(3, 'Géologie', 'Miam les cailloux'),
(4, 'Physique', 'La physique est la science qui tente de comprendre, de modéliser, voire d\'expliquer les phénomènes naturels de l\'univers. Elle correspond à l\'étude du monde qui nous entoure sous toutes ses formes, des lois de sa variation et de son évolution.'),
(5, 'Interview', 'donne des interviews dans le milieu de la science'),
(6, 'Journalisme', 'Vulgarisation du journalisme ou fait du journalisme scientifique'),
(7, 'Droit', 'Tout ce qui touche au droit, au juridique..'),
(8, 'Science fiction', 'qui n\'aime pas ! '),
(9, 'Zetetique  - esprit critique - rationalisme', 'C\'est les faits épisétout'),
(10, 'Neuroscience', 'Le cerveau ! '),
(11, 'Histoire', 'avec un grand H '),
(12, 'Biologie', 'le vivant '),
(13, 'Astrophysique', 'Le ciel ! '),
(14, 'Science de la vie', 'et de la terre !'),
(15, 'Spatiale', 'les fusée, l\'espace'),
(16, 'Mathématiques', '-3x² + 13x + 126 = 0'),
(17, 'Méthode scientifique', 'épistémologie duh ! '),
(18, 'Art', 'la beauté ! '),
(19, 'Chimie', 'un peu de si un peu de ça et BOOM'),
(20, 'Psychologie', 'à ne pas confondre avec psychanalyse '),
(21, 'Archéologie', 'C\'est sous la terre (souvent!)'),
(22, 'Linguistique', 'Les langues, slurp ! '),
(23, 'La mort', '💀'),
(24, 'Le sexe', 'consentant bien sur ');

-- --------------------------------------------------------

--
-- Table structure for table `domaine_vulga`
--

CREATE TABLE `domaine_vulga` (
  `id` int(11) NOT NULL,
  `domaine` int(11) NOT NULL,
  `vulga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domaine_vulga`
--

INSERT INTO `domaine_vulga` (`id`, `domaine`, `vulga`) VALUES
(24, 3, 7),
(25, 5, 7),
(26, 6, 7),
(27, 7, 8),
(28, 8, 9),
(29, 5, 10),
(30, 6, 10),
(31, 9, 10),
(32, 10, 11),
(33, 11, 12),
(34, 12, 13),
(35, 13, 14),
(36, 14, 14),
(37, 13, 15),
(38, 15, 15),
(39, 16, 16),
(40, 4, 16),
(41, 16, 17),
(42, 4, 17),
(43, 12, 18),
(44, 16, 19),
(45, 17, 19),
(46, 4, 19),
(47, 16, 20),
(48, 4, 20),
(49, 18, 21),
(50, 19, 22),
(51, 17, 23),
(52, 20, 23),
(53, 21, 24),
(54, 11, 24),
(55, 22, 25),
(56, 21, 26),
(57, 11, 26),
(58, 23, 26),
(59, 24, 27),
(60, 12, 28),
(61, 22, 28),
(62, 13, 29),
(63, 15, 29),
(64, 16, 30);

-- --------------------------------------------------------

--
-- Table structure for table `langue`
--

CREATE TABLE `langue` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drapeau` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `langue`
--

INSERT INTO `langue` (`id`, `nom`, `code`, `drapeau`) VALUES
(2, 'Français', 'fr', '🇫🇷'),
(4, 'Anglais', 'en', '🇬🇧'),
(5, 'Allemand', 'de', '🇩🇪');

-- --------------------------------------------------------

--
-- Table structure for table `main_stats`
--

CREATE TABLE `main_stats` (
  `id` int(11) NOT NULL,
  `plateforme` int(11) NOT NULL,
  `vulga` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `follower` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `plateforme_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_posts` int(11) NOT NULL DEFAULT 0,
  `total_like` int(11) NOT NULL,
  `total_dislike` int(11) DEFAULT NULL,
  `total_vue` int(11) NOT NULL DEFAULT 0,
  `total_comment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `drapeau` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`id`, `nom`, `code`, `drapeau`) VALUES
(1, 'France', 'fr', '🇫🇷'),
(2, 'Belgique', 'be', '🇧🇪'),
(3, 'Suisse', 'ch', '🇨🇭'),
(4, 'Allemagne', 'de', '🇩🇪'),
(5, 'Royaume-uni', 'gb', '🇬🇧'),
(7, 'Australie', 'au', '🇦🇺'),
(8, 'Canada', 'ca', '🇨🇦'),
(9, 'Etats-unis', 'us', '🇺🇸');

-- --------------------------------------------------------

--
-- Table structure for table `plateforme`
--

CREATE TABLE `plateforme` (
  `id` int(11) NOT NULL,
  `nom` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_extract_pattern` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plateforme`
--

INSERT INTO `plateforme` (`id`, `nom`, `address`, `post_name`, `id_extract_pattern`) VALUES
(3, 'Youtube', 'https://www.youtube.com/', 'Vidéos', '/^(?:https?:\\/\\/)?(?:m\\.|www\\.)?(?:youtu\\.be\\/|youtube\\.com\\/channel\\/)([a-zA-Z0-9_\\-]{1,})$/'),
(4, 'Twitter', 'https://twitter.com/', 'Tweets', '/^(?:(?:https?:\\/\\/)?(?:www\\.)?twitter\\.com\\/)?(?:@|#!\\/)?([A-Za-z0-9_]{1,20})?$/'),
(5, 'Instagram', 'https://www.instagram.com/', 'Posts', '/(?:(?:http|https):\\/\\/)?(?:www.)?(?:instagram.com|instagr.am)\\/([A-Za-z0-9-_\\.]+)/im');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plateforme` int(11) NOT NULL,
  `vulga` int(11) NOT NULL,
  `vue` int(11) NOT NULL,
  `Titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nb_like` int(11) NOT NULL,
  `nb_dislike` int(11) NOT NULL,
  `comments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regkey`
--

CREATE TABLE `regkey` (
  `id` int(11) NOT NULL,
  `reg_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `pwd_reset_token` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `date_created`, `pwd_reset_token`, `pwd_reset_token_creation_date`) VALUES
(2, 'Arkhchance@protonmail.com', 'Arkhchance', '$argon2id$v=19$m=131072,t=16,p=4$YjBJanl0SnR4Y1RGaWxlSw$BM4NZKde/U8mGOYNi1/G8dsijOih+rCwpurHCBo4APY', '2019-07-29 08:46:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vulga`
--

CREATE TABLE `vulga` (
  `id` int(11) NOT NULL,
  `nom` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` int(11) NOT NULL,
  `langue` int(11) NOT NULL,
  `pays` int(11) NOT NULL,
  `private` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vulga`
--

INSERT INTO `vulga` (`id`, `nom`, `sexe`, `langue`, `pays`, `private`) VALUES
(7, 'Science de comptoir', 0, 2, 1, 0),
(8, '911 Avocat', 0, 2, 1, 0),
(9, 'Ana D', 0, 2, 1, 0),
(10, 'Aude WTFake', 0, 2, 1, 0),
(11, 'BrainWhy', 0, 2, 1, 0),
(12, 'C\'est une autre histoire', 0, 2, 1, 0),
(13, 'Castor Mother', 0, 2, 1, 0),
(14, 'Eva t\'expliquer', 0, 2, 1, 0),
(15, 'Florence Porcel', 0, 2, 1, 0),
(16, 'Up and Atom', 0, 4, 7, 0),
(17, 'Tibees', 0, 4, 7, 0),
(18, 'Tania Louis', 0, 2, 1, 0),
(19, 'Scilabus', 0, 2, 8, 0),
(20, 'Physics Girl', 0, 4, 9, 0),
(21, 'NART l\'art en 3 coups de pinceau', 0, 2, 1, 0),
(22, 'Molécules', 0, 2, 1, 0),
(23, 'Macroscopie La chaine', 0, 2, 1, 0),
(24, 'Les Revues du Monde', 0, 2, 1, 0),
(25, 'Les Langues de Cha\'', 0, 2, 1, 0),
(26, 'Le Bizarreum', 0, 2, 1, 0),
(27, 'La science du cul', 0, 2, 1, 0),
(28, 'la P\'tite Jane', 0, 2, 1, 0),
(29, 'la fille dans la lune', 0, 2, 1, 0),
(30, 'Katie Steckles', 0, 4, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vulga_plateforme`
--

CREATE TABLE `vulga_plateforme` (
  `id` int(11) NOT NULL,
  `vulga` int(11) NOT NULL,
  `plateforme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `domaine`
--
ALTER TABLE `domaine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domaine_vulga`
--
ALTER TABLE `domaine_vulga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vulga _link` (`vulga`),
  ADD KEY `domaine_link` (`domaine`);

--
-- Indexes for table `langue`
--
ALTER TABLE `langue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_stats`
--
ALTER TABLE `main_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plateforme_link` (`plateforme`),
  ADD KEY `vulga_link` (`vulga`);

--
-- Indexes for table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plateforme`
--
ALTER TABLE `plateforme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plateforme_post` (`plateforme`),
  ADD KEY `vulga_post` (`vulga`);

--
-- Indexes for table `regkey`
--
ALTER TABLE `regkey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vulga`
--
ALTER TABLE `vulga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langue_link` (`langue`),
  ADD KEY `pays_link` (`pays`);

--
-- Indexes for table `vulga_plateforme`
--
ALTER TABLE `vulga_plateforme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`vulga`),
  ADD KEY `id_vulga` (`plateforme`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `domaine`
--
ALTER TABLE `domaine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `domaine_vulga`
--
ALTER TABLE `domaine_vulga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `langue`
--
ALTER TABLE `langue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `main_stats`
--
ALTER TABLE `main_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `plateforme`
--
ALTER TABLE `plateforme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regkey`
--
ALTER TABLE `regkey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vulga`
--
ALTER TABLE `vulga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `vulga_plateforme`
--
ALTER TABLE `vulga_plateforme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `domaine_vulga`
--
ALTER TABLE `domaine_vulga`
  ADD CONSTRAINT `domaine_link` FOREIGN KEY (`domaine`) REFERENCES `domaine` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `vulga _link` FOREIGN KEY (`vulga`) REFERENCES `vulga` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `main_stats`
--
ALTER TABLE `main_stats`
  ADD CONSTRAINT `plateforme_link` FOREIGN KEY (`plateforme`) REFERENCES `plateforme` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `vulga_link` FOREIGN KEY (`vulga`) REFERENCES `vulga` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `plateforme_post` FOREIGN KEY (`plateforme`) REFERENCES `plateforme` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `vulga_post` FOREIGN KEY (`vulga`) REFERENCES `vulga` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vulga`
--
ALTER TABLE `vulga`
  ADD CONSTRAINT `langue_link` FOREIGN KEY (`langue`) REFERENCES `langue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pays_link` FOREIGN KEY (`pays`) REFERENCES `pays` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vulga_plateforme`
--
ALTER TABLE `vulga_plateforme`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`vulga`) REFERENCES `vulga` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_vulga` FOREIGN KEY (`plateforme`) REFERENCES `plateforme` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
