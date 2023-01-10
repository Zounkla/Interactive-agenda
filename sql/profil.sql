-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 02 jan. 2022 à 11:58
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
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `pseudo` varchar(25) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `ville` varchar(60) NOT NULL,
  `pays` varchar(45) NOT NULL,
  `couleur` varchar(7) NOT NULL,
  `style` varchar(45) NOT NULL,
  `id` int(11) NOT NULL,
  `nombre_jours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`pseudo`, `mail`, `mdp`, `ville`, `pays`, `couleur`, `style`, `id`, `nombre_jours`) VALUES
('test', 'test@gmail.com', '$2y$10$lMjUp91t/JVs4bbtQX1ijejuR2QmmuNmxM.pzb', '', '', 'chaud', '', 37, 7),
('Zounkla', 'flo-vl@orange.fr', '$2y$10$14pZDY2nC/fILdEl2B5gy.W7Xj8jJDacx4wQXx8YcNVrpAspbJxdK', 'Sacquenville', 'fr', 'chaud', 'overline', 42, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
