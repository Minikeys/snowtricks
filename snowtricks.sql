-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 15 Juillet 2019 à 18:02
-- Version du serveur :  10.3.16-MariaDB-1:10.3.16+maria~stretch
-- Version de PHP :  7.3.7-1+0~20190710.40+debian9~1.gbp032aec

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Grabs'),
(2, 'Rotations'),
(3, 'Flips'),
(4, 'Rotations désaxées'),
(5, 'Slides');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_at` datetime NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added_at` datetime NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `media`
--

INSERT INTO `media` (`id`, `trick_id`, `file`, `type`, `added_at`, `link`) VALUES
(1, 1, NULL, 'youtube', '2019-07-14 15:46:22', '51sQRIK-TEI'),
(2, 2, NULL, 'youtube', '2019-07-14 15:48:08', 'KEdFwJ4SWq4'),
(3, 2, '5d2b33c85f44e.jpg', 'picture', '2019-07-14 15:53:12', NULL),
(4, 3, NULL, 'youtube', '2019-07-14 15:57:17', 't0F1sKMUChA');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190708141516', '2019-07-08 14:16:16'),
('20190708170338', '2019-07-08 17:03:54'),
('20190714155837', '2019-07-14 15:59:03'),
('20190714191732', '2019-07-14 19:17:48'),
('20190714191848', '2019-07-14 19:19:03'),
('20190714191907', '2019-07-14 19:19:24'),
('20190714191927', '2019-07-14 19:19:38'),
('20190714191942', '2019-07-14 19:19:57'),
('20190714192001', '2019-07-14 19:20:11'),
('20190714192014', '2019-07-14 19:20:24'),
('20190714192028', '2019-07-14 19:20:50');

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

CREATE TABLE `trick` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `trick`
--

INSERT INTO `trick` (`id`, `category_id`, `author_id`, `name`, `description`, `picture`, `slug`, `created_at`, `update_at`, `published`) VALUES
(1, 1, 1, 'mute', '<p style=\"text-align: justify;\">Saisie de la carre <em>frontside</em> de la planche entre les deux pieds avec la main avant.</p>', '5d2b2b5db635d.jpeg', 'mute', '2019-07-08 19:11:47', '2019-07-14 15:54:18', 1),
(2, 1, 1, 'sad', '<p style=\"text-align: justify;\">Saisie de la carre <em>backside</em> de la planche, entre les deux pieds, avec la main avant.</p>', '5d2b3389a48a9.jpg', 'sad', '2019-07-14 15:25:50', '2019-07-14 18:01:35', 1),
(3, 1, 1, 'Indy', '<p>Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arri&egrave;re.</p>', '5d2b34861e7fb.jpg', 'indy', '2019-07-14 15:56:22', '2019-07-14 15:57:20', 1),
(4, 1, 1, 'Stalefish', 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.', '5d2b35046d6ac.jpg', 'stalefish', '2019-07-14 15:58:28', '2019-07-14 15:58:28', 1),
(5, 1, 1, 'Seat belt', 'Saisie du carre frontside à l\'arrière avec la main avant.', '5d2b354a77b71.jpg', 'seat-belt', '2019-07-14 15:59:38', '2019-07-14 15:59:38', 1),
(6, 2, 1, '180', 'Un 180 désigne un demi-tour, soit 180 degrés d\'angle.', '5d2b35f1e1b73.jpg', '180', '2019-07-14 16:02:25', '2019-07-14 16:02:25', 1),
(7, 3, 1, 'Front flips', 'Le front flips et une rotations en avant.', '5d2b366b63388.jpg', 'front-flips', '2019-07-14 16:04:27', '2019-07-14 16:04:27', 1),
(8, 5, 1, 'Tail slide', '<p style=\"text-align: justify;\">On peut slider avec la planche centr&eacute;e par rapport &agrave; la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en nose slide, c\'est-&agrave;-dire l\'avant de la planche sur la barre, ou en tail slide, l\'arri&egrave;re de la planche sur la barre.</p>', '5d2b36dda7438.jpg', 'tail-slide', '2019-07-14 16:06:21', '2019-07-14 16:06:40', 1),
(9, 1, 1, 'Japan air', 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.', '5d2b377abee4f.jpg', 'japan-air', '2019-07-14 16:08:58', '2019-07-14 16:08:58', 1),
(10, 1, 1, 'Nose grab', 'Saisie de la partie avant de la planche, avec la main avant.', '5d2b37ec77cff.jpg', 'nose-grab', '2019-07-14 16:10:52', '2019-07-14 16:10:52', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `activate_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_activate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CB281BE2E` (`trick_id`),
  ADD KEY `IDX_9474526CF675F31B` (`author_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6A2CA10CB281BE2E` (`trick_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `trick`
--
ALTER TABLE `trick`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D8F0A91E989D9B62` (`slug`),
  ADD UNIQUE KEY `UNIQ_D8F0A91E5E237E06` (`name`),
  ADD KEY `IDX_D8F0A91E12469DE2` (`category_id`),
  ADD KEY `IDX_D8F0A91EF675F31B` (`author_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `trick`
--
ALTER TABLE `trick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
