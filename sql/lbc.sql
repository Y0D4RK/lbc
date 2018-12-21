-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 21 Décembre 2018 à 13:18
-- Version du serveur :  5.7.24-0ubuntu0.16.04.1
-- Version de PHP :  7.1.25-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lbc`
--

-- --------------------------------------------------------

--
-- Structure de la table `advert`
--

CREATE TABLE `advert` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `uuid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `advert`
--

INSERT INTO `advert` (`id`, `user_id`, `title`, `description`, `created_at`, `updated_at`, `uuid`, `category_id`) VALUES
(1, 1, 'advert_1', 'advert_1', '2018-12-16 00:00:00', '2018-12-16 00:00:00', 'dafed560-8107-11e8-a079-0242c7ad7683', 1),
(2, 1, 'advert_2', 'advert_2', '2018-12-16 00:00:00', '2018-12-16 00:00:00', 'dafed560-8107-11e8-a079-0242c7ad7684', 2),
(3, 1, 'advert_3', 'advert_4', '2018-12-21 11:41:16', '2018-12-21 11:41:16', 'f1dab93c-050c-11e9-93cc-0242b2f54642', 3);

-- --------------------------------------------------------

--
-- Structure de la table `categories_fields`
--

CREATE TABLE `categories_fields` (
  `category_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `categories_fields`
--

INSERT INTO `categories_fields` (`category_id`, `field_id`) VALUES
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `label`) VALUES
(1, 'automobile'),
(2, 'emploi'),
(3, 'immobilier');

-- --------------------------------------------------------

--
-- Structure de la table `field`
--

CREATE TABLE `field` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `field`
--

INSERT INTO `field` (`id`, `type`, `name`) VALUES
(1, 'string', 'volume'),
(2, 'string', 'color'),
(3, 'string', 'price');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `password`, `email`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'jdoe', 'John', 'Doe', '$2y$13$NcGsxf/BXGospxeRn43he.LNr3TCYa7Lo8lRtposCf/NkCQn/zqcy', 'john_doe@mail.com', '2018-12-16 03:08:46', '2018-12-16 03:08:46', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `advert`
--
ALTER TABLE `advert`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_54F1F40BD17F50A6` (`uuid`),
  ADD UNIQUE KEY `UNIQ_54F1F40B2B36786B` (`title`),
  ADD KEY `IDX_54F1F40BA76ED395` (`user_id`),
  ADD KEY `IDX_54F1F40B12469DE2` (`category_id`);

--
-- Index pour la table `categories_fields`
--
ALTER TABLE `categories_fields`
  ADD PRIMARY KEY (`category_id`,`field_id`),
  ADD KEY `IDX_768CDDB012469DE2` (`category_id`),
  ADD KEY `IDX_768CDDB0443707B0` (`field_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C1EA750E8` (`label`);

--
-- Index pour la table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `advert`
--
ALTER TABLE `advert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `field`
--
ALTER TABLE `field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `advert`
--
ALTER TABLE `advert`
  ADD CONSTRAINT `FK_54F1F40B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_54F1F40BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `categories_fields`
--
ALTER TABLE `categories_fields`
  ADD CONSTRAINT `FK_768CDDB012469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_768CDDB0443707B0` FOREIGN KEY (`field_id`) REFERENCES `field` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
