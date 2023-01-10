-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 02 jan. 2022 à 11:59
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vanliflo`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `nom` varchar(50) NOT NULL,
  `localisation` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `id_event` int(10) NOT NULL,
  `id_compte` int(10) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `diffdate` int(11) NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`nom`, `localisation`, `description`, `id_event`, `id_compte`, `date_debut`, `date_fin`, `diffdate`, `heure_debut`, `heure_fin`) VALUES
('TEST', 'TEST', 'TEST', 14479, 19, '2021-11-11', '2021-11-25', 14, '16:00:00', '15:12:00'),
('ea', 'e', 'ggy', 14493, 19, '2021-11-27', '2021-11-28', 1, '16:00:00', '17:02:00'),
('veayuei', 'y_e', 'g', 14494, 19, '2021-11-28', '2021-11-29', 1, '16:00:00', '00:25:00'),
('AAAA', 'CCCC', 'BBBB', 14495, 19, '2021-11-26', '2021-11-27', 1, '16:00:00', '22:52:00'),
('euauae', 'ue', 'u', 14496, 19, '2021-11-26', '2021-11-26', 0, '15:00:00', '15:00:00'),
('e', 't-', 'uuh', 14498, 19, '2021-11-27', '2021-11-29', 2, '16:00:00', '16:00:00'),
('hello', 'B', 'rush', 14499, 31, '2021-12-08', '2021-12-08', 0, '16:00:00', '16:00:00'),
('je ', 'pas', 'sais', 14500, 31, '2021-12-13', '2021-12-13', 0, '16:00:00', '16:00:00'),
('e', 'geygu', 'ugeg', 14508, 42, '2022-01-06', '2022-01-08', 2, '16:00:00', '16:00:00'),
('je sais pas', 'par l&agrave;', 'encore', 14516, 42, '2021-12-31', '2021-12-31', 0, '16:00:00', '16:00:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id_event` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14518;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
