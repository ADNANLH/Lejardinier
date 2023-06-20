-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 juin 2023 à 16:37
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jardinier`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(255) DEFAULT NULL,
  `cin` varchar(222) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `cin`, `email`, `password`) VALUES
(1, 'John Doe', 'KL4343', '123 Main St', '1234567890'),
(2, 'Jane Smith', 'L34343', '456 Elm St', '0987654321'),
(3, 'Mike Johnson', '44342LL', '789 Oak St', '1112223333'),
(4, 'Bo Long', NULL, 'lizyva@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(5, 'Priscilla Hardy', 'Hashim Albert', 'xydozu@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(6, 'Susan Quinn', 'Farrah Rich', 'jewedavo@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(7, 'Naida Noel', 'Adria Tillman', 'vudodubiq@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(8, 'Salvador Avila', 'Mara Velasquez', 'codyjyq@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3'),
(9, 'adnan lharrak', 'K6347434', 'adnanharrak5@gmail.com', '08f90c1a417155361a5c4b8d297e0d78'),
(10, 'Gemma Odom', 'Ulla Snider', 'oumlh@outlook.fr', 'a9b7ba70783b617e9998dc4dd82eb3c5');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `date`, `etat`, `id_client`) VALUES
(12, '2023-06-19', 'Terminée', 9),
(13, '2023-06-19', 'Terminée', 9),
(14, '2023-06-19', 'Terminée', 9),
(16, '2023-06-19', 'En attente', 9),
(17, '2023-06-20', 'En attente', 9),
(18, '2023-06-20', 'En attente', 9),
(19, '2023-06-20', 'Terminée', 10);

-- --------------------------------------------------------

--
-- Structure de la table `favorit`
--

CREATE TABLE `favorit` (
  `id_favorit` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_plant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favorit`
--

INSERT INTO `favorit` (`id_favorit`, `id_client`, `id_plant`) VALUES
(16, 9, 18),
(18, 9, 20),
(26, 10, 13);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id_ligne_cmd` int(11) NOT NULL,
  `id_commande` int(11) DEFAULT NULL,
  `id_plant` int(11) DEFAULT NULL,
  `qnt_unt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id_ligne_cmd`, `id_commande`, `id_plant`, `qnt_unt`) VALUES
(10, 12, 22, 2),
(11, 13, 13, 4),
(12, 14, 16, 1),
(14, 16, 20, 2),
(15, 17, 17, 2),
(16, 18, 17, 1),
(17, 19, 13, 2);

-- --------------------------------------------------------

--
-- Structure de la table `plant`
--

CREATE TABLE `plant` (
  `id_plant` int(11) NOT NULL,
  `nom_plant` varchar(255) DEFAULT NULL,
  `image` varchar(222) NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `lumiere` varchar(255) DEFAULT NULL,
  `arrosage` varchar(255) DEFAULT NULL,
  `humidite` varchar(255) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `plant`
--

INSERT INTO `plant` (`id_plant`, `nom_plant`, `image`, `prix`, `description`, `lumiere`, `arrosage`, `humidite`, `quantite`) VALUES
(13, 'Money Tree', '648fa16b9f0453.47939644.jpg', 130.00, 'Lorsqu\'ils sont placés dans le bon environnement, les Monsteras sont faciles à entretenir et à croissance rapide, alors donnez-leur un peu d\'espace pour s\'étendre, faire une déclaration et prospérer ! Au fur et à mesure que le Monstera grandit, ses feuilles développeront de longs rubans et des trous, ressemblant à du fromage suisse, lui donnant un aspect graphique distinct.\r\n\r\nComposé de plusieurs plantes de Pachinra aquatica tressées ensemble, le Money Tree ressemble à la fois à un arbre et à un palmier. Originaire du Mexique au nord de l\'Amérique du Sud où il pousse jusqu\'à 60 pieds de haut à l\'extérieur, c\'est une plante d\'intérieur que l\'on trouve couramment en Asie de l\'Est où la culture du tronc tressé a été popularisée.', 'mi_ombre', 'quotidien', 'elevee', 2),
(15, 'Fiddle Leaf Fig', '648fa28faec5a4.23119399.jpg', 219.00, 'La Fiddle Leaf Fig est facilement reconnaissable et appréciée pour son feuillage distinctif. Cette grande plante spectaculaire a de très grandes feuilles en forme de violon fortement veinées qui poussent debout. Ce n\'est pas touffu, ce qui en fait un bel ajout de design d\'intérieur pour un coin bien éclairé ou un coin confortable dans votre maison.', 'ombre', 'quotidien', 'faible', 13),
(16, 'Variegated Schefflera', '648fa39f99cf97.99028062.jpg', 89.00, ' Plante d\'intérieur ludique avec des formations de feuilles en forme de parapluie, le Schefflera panaché est une plante d\'intérieur incontournable dans votre collection. Taché de jaunes crémeux et de verts profonds, sa forme compacte, ses motifs audacieux et sa nature décontractée en font un cadeau idéal pour les débutants pour un nouveau parent de plante. Cette plante apprécie une lumière indirecte faible à vive et des arrosages peu fréquents. Vous pouvez garder ses feuilles propres en les époussetant souvent.', 'mi_ombre', 'quotidien', 'faible', 6),
(17, 'Burgundy Rubber Tree', '648fa3e976c245.16323932.jpg', 95.00, 'Robuste et spectaculaire, l\'hévéa de Bourgogne arbore de grandes feuilles brillantes sur des tiges dressées et durables. Cette plante saisissante est prête à faire sensation dans votre maison avec sa palette de couleurs sombres et maussades allant du vert forêt profond au riche rouge bordeaux. Cette plante nécessitant peu d\'entretien sera plus heureuse dans un endroit avec une lumière indirecte brillante.', 'ombre', 'hebdomadaire', 'faible', 7),
(18, 'Sansevieria', '648fa45b2593e6.54006251.jpg', 129.00, 'Si vous êtes nouveau propriétaire de plantes ou si vous recherchez simplement une plante d\'intérieur facile d\'entretien, la Sansevieria est la plante qu\'il vous faut. Cette plante rustique reste populaire en raison de sa capacité d\'adaptation à un large éventail de conditions de croissance. Il peut supporter le plein soleil et supporter une faible luminosité, bien qu\'il fasse mieux en plein soleil indirect. Et parce que le Sansevieria est originaire des déserts arides d\'Afrique de l\'Ouest, il ne nécessite pas beaucoup d\'eau, surtout en hiver.', 'mi_ombre', 'hebdomadaire', 'moderee', 23),
(19, 'Tough Stuff Collection', '648fa557536bb9.67895152.jpg', 230.00, 'Que vous commenciez votre famille de plantes ou que vous en ajoutiez, ces plantes faciles sélectionnées à la main sont parfaites pour des conditions moins qu\'idéales. Chacune de ces trois plantes est incroyablement facile, s\'adaptera à presque toutes les lumières disponibles et est extrêmement indulgente. Leur nature facile à vivre les rend parfaits pour les bureaux, les dortoirs et les débutants.', 'ombre', 'hebdomadaire', 'faible', 59),
(20, 'Peace Lily', '648fa6e1bf2ee7.68407572.jpg', 70.00, 'Le lys de la paix est une plante d\'intérieur emblématique depuis des décennies grâce à sa nature indulgente, ses feuilles brillantes vibrantes et ses fleurs blanches symboliques. Les grandes feuilles de cette plante donneront à n\'importe quel espace une sensation de jungle luxuriante. Le lys de la paix est devenu le symbole de la prospérité, de la pureté, de la paix et de la sympathie, ce qui en fait un cadeau sincère parfait. Plus susceptible de fleurir sous une lumière indirecte vive, cette plante tolère tout niveau de lumière indirecte, y compris une faible luminosité.', 'mi_ombre', 'hebdomadaire', 'faible', 37),
(21, 'Prickly Pear Cactus', '648fa7d2390b21.77911743.jpg', 60.00, 'Un cactus ludique avec des coussinets en forme de queue de castor, le Prickly Pear Cactus est une plante nécessitant peu d\'entretien avec une routine d\'entretien sans tracas avec un arrosage et une fertilisation peu fréquents.', 'plein_soleil', 'mensuel', 'faible', 34),
(22, 'Hedgehog Aloe', '648fa858f39fa0.40905209.jpg', 140.00, 'Hedgehog Aloe est une succulente très indulgente, ce qui en fait une plante parfaite pour les ménages agités ou pour les nouveaux propriétaires. Cette plante fait toute une impression avec ses feuilles bleu-vert et produit souvent des épis uniques de fleurs rouge corail au printemps et à la fin de l\'été.', 'mi_ombre', 'hebdomadaire', 'moderee', 85),
(23, 'Mini Money Tree', '648fa8e3a4d787.23813677.jpg', 299.00, 'Une plante vivante, adaptée aux animaux de compagnie, surmontée de feuilles palmées sur un tronc robuste. Une mini-version du bien-aimé Money Tree tressé', 'mi_ombre', 'quotidien', 'moderee', 100),
(24, 'Mini Beginner Set', '648fadfec58447.44508152.jpg', 220.00, 'Que vous commenciez tout juste votre parcours de parents de plantes ou que vous souhaitiez aider un être cher à démarrer le sien, l\'ensemble Mini Beginner vous couvre. Rencontrez le Hedgehog Aloe facile à vivre, le délicieux Money Tree et le classique Philodendron Heartleaf. Chaque plante de ce lot peut être placée dans une variété de conditions d\'éclairage et ne nécessite pas d\'arrosage constant. En bref, ce sont des plantes de démarrage faciles d\'entretien qui vous aideront à développer votre pouce vert !', 'mi_ombre', 'hebdomadaire', 'moderee', 28),
(25, 'ZZ Plante', '648faea28049d1.10775993.jpg', 230.00, 'Cette plante d\'intérieur est résistante, ce qui la rend idéale pour le propriétaire de plante oublieux. La plante ZZ facile d\'entretien est capable de survivre pendant des semaines sans eau et poussera bien sous n\'importe quelle lumière sauf la lumière directe du soleil.', 'plein_soleil', 'quotidien', 'moderee', 45);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`id_favorit`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_plant` (`id_plant`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id_ligne_cmd`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_plant` (`id_plant`);

--
-- Index pour la table `plant`
--
ALTER TABLE `plant`
  ADD PRIMARY KEY (`id_plant`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `favorit`
--
ALTER TABLE `favorit`
  MODIFY `id_favorit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id_ligne_cmd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `plant`
--
ALTER TABLE `plant`
  MODIFY `id_plant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `favorit`
--
ALTER TABLE `favorit`
  ADD CONSTRAINT `favorit_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `favorit_ibfk_2` FOREIGN KEY (`id_plant`) REFERENCES `plant` (`id_plant`);

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `ligne_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `ligne_commande_ibfk_2` FOREIGN KEY (`id_plant`) REFERENCES `plant` (`id_plant`);

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`root`@`localhost` EVENT `update_command_status_event` ON SCHEDULE EVERY 1 DAY STARTS '2023-06-20 12:25:08' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Calculate the date three days ago
    SET @threeDaysAgo = DATE_SUB(CURDATE(), INTERVAL 3 DAY);
    
    -- Update the status of the commands to 'annulée' if they are still 'en attente' after three days
    UPDATE Commande
    SET etat = 'annulée'
    WHERE etat = 'en attente' AND date <= @threeDaysAgo;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
