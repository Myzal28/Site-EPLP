-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Lun 09 Septembre 2019 à 10:43
-- Version du serveur :  5.7.27-0ubuntu0.18.04.1
-- Version de PHP :  7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `eplp`
--

-- --------------------------------------------------------

--
-- Structure de la table `guess_secret`
--

CREATE TABLE `guess_secret` (
  `id` int(11) NOT NULL,
  `id_secret` int(11) NOT NULL,
  `id_user_accused` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `guess_secret`
--

INSERT INTO `guess_secret` (`id`, `id_secret`, `id_user_accused`, `id_user`, `datetime`) VALUES
(3, 6, 6, 3, '2019-09-04 14:50:22');

-- --------------------------------------------------------

--
-- Structure de la table `kill_history`
--

CREATE TABLE `kill_history` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_killer` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `used` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mission`
--

INSERT INTO `mission` (`id`, `title`, `description`, `logo`, `used`) VALUES
(1, 'L\'habit ne fait pas le moine', 'Subtilise habilement un t-shirt et un short/pantalon à {joueur} et porte les pour aller en boîte', 'fas fa-tshirt', 1),
(2, 'Johnny B. Goode', 'Danse un long rock avec {joueur} durant une soirée en boîte', 'fas fa-compact-disc', 1),
(3, 'Pardon ? ', 'Faire répéter 4 fois d\'affilée à {joueur} pendant qu\'il/elle parle', 'fas fa-question', 1),
(4, 'Un dernier pour la route', 'Fais boire 3 culs secs à {joueur} dans la même soirée', 'fas fa-beer', 0),
(5, 'Une photo pour mamie', 'Fais toi prendre en photo par un passant en compagnie de {joueur}. Attention ! Vous seuls devez apparaître sur la photo', 'fas fa-camera-retro', 0),
(6, 'C\'est pour Insta !', 'Prends 10 selfies dans la même soirée (pas d\'affilée) avec {joueur} sans éveiller de soupçons', 'fab fa-instagram', 0),
(7, 'Salud !', 'Fais en sorte que {joueur} trinque avec une personne étrangère, de préférence espagnole', 'fas fa-glass-cheers', 1),
(8, 'T\'as pas du feu ?', 'Ta cible est {joueur}.<br>\nSi tu es fumeur et que ta cible est non fumeur :\n<br> fais lui allumer ta clope 2 fois dans la soirée <br><br>\nSi tu es fumeur et que ta cible est fumeur : <br>\nFais lui allumer ta clope 10 fois dans la même soirée<br><br>\nSi tu es non fumeur et que ta cible est fumeur : <br>\nAllume la clope de ta cible 5 fois dans la soirée <br><br>\nSi tu es non fumeur et que ta cible est non fumeur : <br>\nDonne un briquet à ta cible et fais lui allumer une clope dans la soirée', 'fas fa-smoking', 1),
(9, 'Ça fait un peu Jacques a dit pas de charcuterie', 'Tiens une discussion de 5mn avec {joueur} à propos des vegans', 'fas fa-carrot', 0),
(10, 'Degolass', 'Convaincs {joueur} de manger un truc dégueu en lui faisant croire que c\'est bon', 'fas fa-hotdog', 1),
(11, 'Blbbllblbl', 'Coule {joueur} dans la piscine ou dans la mer sans qu\'il/elle te recoule derrière !', 'fas fa-swimming-pool', 1),
(12, 'Buffalo', 'Fais un buffalo à {joueur}', 'fas fa-beer', 1),
(13, 'Course d\'orientation', 'Appelle {joueur} et fais lui croire que tu t\'es perdu à Barcelone ', 'far fa-compass', 1),
(14, 'G SOEF', 'Cul sec le verre de {joueur} sans qu\'il s\'en rende compte !', 'fas fa-cocktail', 1),
(15, 'Serveur svp !', 'Fais toi ouvrir une bière au briquet par {joueur}', 'fas fa-user-tie', 1),
(16, 'Barman', 'Fais un cocktail contenant au moins 3 alcools différents à {joueur} et fais lui boire entièrement', 'fas fa-cocktail', 1),
(17, 'Ridikkulus', 'Va faire les boutiques avec {joueur} et fais lui essayer quelque chose de ridicule', 'fas fa-socks', 1),
(19, 'Lloret Confidential', 'Si tu es en couple -> fais croire à {joueur} que tu as complètement déconné avec un(e) inconnu(e) quelques nuit plus tôt mais qu’il faut absolument pas le dire. Si {joueur} y croit jusqu’à la prochaine vague de mission, c’est validé\n<br><br>\nSi tu es célibataire -> isole toi du groupe durant une soirée pendant un moment et fais croire à {joueur} que tu as baisé une meuf sans que personne le sache. \n<br><br>\nATTENTION, si {joueur} révèle cette info top secrète avant la prochaine vague de missions, c’est perdu.\n<br><br>\nCe message s’autodétruira dans 5 secondes', 'fas fa-baby-carriage', 1),
(20, 'Métier : Photographe professionnel', 'Munis toi de ton smartphone, tu disposes de 4 jours pour prendre la plus belle photo possible de {joueur}. \n<br><br>\nTu gagnes la mission si tu parviens à le/la faire poster cette photo sur Instagram avant la prochaine vague de missions', 'fas fa-camera-retro', 1),
(21, 'Daniel Riolo', 'Commente le boule d\'une meuf en faisant un commentaire footballistique, si {joueur} est d\'accord il a perdu <br><br>\nExemple : \"Eh tu trouves pas que le boule de la meuf on dirait un peu la gueule de Mbappe ?\" ', 'fas fa-futbol', 1);

-- --------------------------------------------------------

--
-- Structure de la table `score_history`
--

CREATE TABLE `score_history` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `score_history`
--

INSERT INTO `score_history` (`id`, `user`, `score`, `reason`, `datetime`) VALUES
(1, 2, 5, ' a tué <span class=\"pseudo\">Maxime</span> avec la mission <button class=\"btn btn-vacation\" onclick=\"seeMission(12)\">Buffalo</button>', '2019-09-04 08:58:33');

-- --------------------------------------------------------

--
-- Structure de la table `secrets`
--

CREATE TABLE `secrets` (
  `id` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `found_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `secrets`
--

INSERT INTO `secrets` (`id`, `secret`, `user`, `found_by`) VALUES
(1, 'Secret 1 ', 1, NULL),
(2, 'Secret 2', 2, NULL),
(3, 'Secret 3', 8, NULL),
(4, 'Secret 4 ', 5, NULL),
(5, 'Secret 5', 4, NULL),
(6, 'Secret 6', 9, NULL),
(7, 'Secret 7', 3, NULL),
(8, 'Secret 8', 6, NULL),
(9, 'Secret 9', 7, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT 'test@test.com',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `first_name`, `last_name`, `active`) VALUES
(1, 'maxime.lalo.pro@gmail.com', 'mlalo', '$2y$10$mo7jGv2gnuiizv4/hYFZlecUehevhCINbVEli3cZ64hBQxX4vPRVa', 'Maxime', 'Lalo', 1),
(2, 'maxime.lalo.pro@gmail.com', 'mliaume', '$2y$10$JmB1OOfiQBx914Axbbb7EOvdCq7p7QGUgkWMgk2nN6rgOTNVyyEy.', 'Marin', 'Liaume', 1),
(3, 'maxime.lalo.pro@gmail.com', 'clecozler', '$2y$10$SqxhANkGVzEgQKHjExaucuCw/bN1.4aI/78u7gmJZF7ESs9KeY5Ei', 'Camille', 'Le Cozler', 1),
(4, 'maxime.lalo.pro@gmail.com', 'tbaker', '$2y$10$YOHAsVsTdN6wmpMR8yIpf.zIKCZJpSapvi9yq.tjHx5TD9RlSrzSu', 'Taha', 'Baker', 1),
(5, 'maxime.lalo.pro@gmail.com', 'couertani', '$2y$10$hjs/DE48xzGKx8bIzKY0RuzfKki.wXWzhbcGg4l0yMl/P1SQULUfK', 'Chédi', 'Ouertani', 1),
(6, 'maxime.lalo.pro@gmail.com', 'hogez', '$2y$10$qXTt/QNZX3GbyO./eQyVsuMCJIN6ZbUEWLMsEbhE2dJFRjIRQWKpa', 'Hugo', 'Ogez', 0),
(7, 'maxime.lalo.pro@gmail.com', 'dfacon', '$2y$10$Xhjx1QQr5bby47BqrTZTUuK2zvbFKQqfEEITW/PgKxjglhY3rQszK', 'Damien', 'Facon', 1),
(8, 'maxime.lalo.pro@gmail.com', 'risrael', '$2y$10$QpNUyt7vPPpEIR0MnwvKzuLbANjBaQg88zK3m.bvRWvFqRWN.mul2', 'Raphaël', 'Israel', 1),
(9, 'maxime.lalo.pro@gmail.com', 'lgermain', '$2y$10$Vo.3Pp2Z3/dDLn0FEhwfhOXvi.H1VDdq5LxLOY88XilAh61G6Uf9u', 'Louis', 'Germain', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_mission`
--

CREATE TABLE `user_mission` (
  `id` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `target` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user_mission_state`
--

CREATE TABLE `user_mission_state` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `next_mission` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `guess_secret`
--
ALTER TABLE `guess_secret`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_secret_guess_secret` (`id_secret`),
  ADD KEY `fk_id_user_accused_guess_secret` (`id_user_accused`),
  ADD KEY `fk_id_user_guess_secret` (`id_user`);

--
-- Index pour la table `kill_history`
--
ALTER TABLE `kill_history`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `score_history`
--
ALTER TABLE `score_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_score_history_user` (`user`);

--
-- Index pour la table `secrets`
--
ALTER TABLE `secrets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_secret` (`user`),
  ADD KEY `fk_found_by_secret` (`found_by`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_mission`
--
ALTER TABLE `user_mission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mission_user_mission` (`id_mission`),
  ADD KEY `fk_target_user_mission` (`user`);

--
-- Index pour la table `user_mission_state`
--
ALTER TABLE `user_mission_state`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `guess_secret`
--
ALTER TABLE `guess_secret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `kill_history`
--
ALTER TABLE `kill_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `score_history`
--
ALTER TABLE `score_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `secrets`
--
ALTER TABLE `secrets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `user_mission`
--
ALTER TABLE `user_mission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user_mission_state`
--
ALTER TABLE `user_mission_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `guess_secret`
--
ALTER TABLE `guess_secret`
  ADD CONSTRAINT `fk_id_secret_guess_secret` FOREIGN KEY (`id_secret`) REFERENCES `secrets` (`id`),
  ADD CONSTRAINT `fk_id_user_accused_guess_secret` FOREIGN KEY (`id_user_accused`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_id_user_guess_secret` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `score_history`
--
ALTER TABLE `score_history`
  ADD CONSTRAINT `fk_score_history_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `secrets`
--
ALTER TABLE `secrets`
  ADD CONSTRAINT `fk_found_by_secret` FOREIGN KEY (`found_by`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_user_secret` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
