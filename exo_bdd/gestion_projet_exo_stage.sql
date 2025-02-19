-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 19 fév. 2025 à 09:53
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_projet_exo_stage`
--

-- --------------------------------------------------------

--
-- Structure de la table `affectation`
--

CREATE TABLE `affectation` (
  `id` int NOT NULL,
  `tache_id` int DEFAULT NULL,
  `utilisateur_id` int DEFAULT NULL,
  `role` enum('Responsable','Relecteur','Suiveur') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int NOT NULL,
  `texte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `utilisateur_id` int DEFAULT NULL,
  `tache_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `societe`
--

CREATE TABLE `societe` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateDeadline` datetime DEFAULT NULL,
  `dateCompletion` datetime DEFAULT NULL,
  `etat` enum('en attente','complétée') COLLATE utf8mb4_unicode_ci DEFAULT 'en attente',
  `createur_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tacheliee`
--

CREATE TABLE `tacheliee` (
  `id` int NOT NULL,
  `tache_id` int DEFAULT NULL,
  `tache_reference_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `societe_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affectation`
--
ALTER TABLE `affectation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tache_id` (`tache_id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `tache_id` (`tache_id`);

--
-- Index pour la table `societe`
--
ALTER TABLE `societe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createur_id` (`createur_id`);

--
-- Index pour la table `tacheliee`
--
ALTER TABLE `tacheliee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tache_id` (`tache_id`),
  ADD KEY `tache_reference_id` (`tache_reference_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `societe_id` (`societe_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affectation`
--
ALTER TABLE `affectation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `societe`
--
ALTER TABLE `societe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tacheliee`
--
ALTER TABLE `tacheliee`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affectation`
--
ALTER TABLE `affectation`
  ADD CONSTRAINT `affectation_ibfk_1` FOREIGN KEY (`tache_id`) REFERENCES `tache` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affectation_ibfk_2` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`tache_id`) REFERENCES `tache` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`createur_id`) REFERENCES `utilisateur` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `tacheliee`
--
ALTER TABLE `tacheliee`
  ADD CONSTRAINT `tacheliee_ibfk_1` FOREIGN KEY (`tache_id`) REFERENCES `tache` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tacheliee_ibfk_2` FOREIGN KEY (`tache_reference_id`) REFERENCES `tache` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`societe_id`) REFERENCES `societe` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
