-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 31 Décembre 2014 à 19:26
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `forum_lo`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_STATUT` int(11) NOT NULL DEFAULT '4',
  `USER_PSEUDO` varchar(30) NOT NULL,
  `USER_MAIL` varchar(50) DEFAULT NULL,
  `USER_HASH` varchar(255) NOT NULL,
  `USER_TELEPHONE` varchar(10) DEFAULT NULL,
  `USER_IP` varchar(16) NOT NULL,
  `USER_AVATAR` varchar(30) DEFAULT NULL,
  `USER_DATEINSCRIPTION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `USER_DATECONNEXION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `USER_NOM` varchar(30) NOT NULL,
  `USER_PRENOM` varchar(30) NOT NULL,
  `USER_NAISSANCE` int(11) DEFAULT NULL,
  `USER_NBRECOMMENTAIRESBLOG` int(11) DEFAULT NULL,
  `USER_NBRECOMMENTAIRESFORUM` int(11) DEFAULT NULL,
  `USER_PAYS` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`USER_ID`, `USER_STATUT`, `USER_PSEUDO`, `USER_MAIL`, `USER_HASH`, `USER_TELEPHONE`, `USER_IP`, `USER_AVATAR`, `USER_DATEINSCRIPTION`, `USER_DATECONNEXION`, `USER_NOM`, `USER_PRENOM`, `USER_NAISSANCE`, `USER_NBRECOMMENTAIRESBLOG`, `USER_NBRECOMMENTAIRESFORUM`, `USER_PAYS`) VALUES
(2, 4, 'dferfa', 'fred.tarreau@wanadoo.fr', '$2y$10$dLoKM3Jd.P0OSXnbOlwkbuKHy7FrobgkEiTDDxQopAFCroT4sVKKi', '0156285458', '192.168.1.2', 'DFQf', '2014-12-26 22:23:06', '2014-12-26 22:23:06', 'fDQf', 'wxfqdsf', 1968, 0, 0, 'dfSDG');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;