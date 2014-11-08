-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 28 Octobre 2014 à 21:00
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
-- Structure de la table `t_article`
--

CREATE TABLE IF NOT EXISTS `t_article` (
  `ART_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ART_TITRE` varchar(100) NOT NULL,
  `ART_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ART_DATE_MODIF` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ART_CONTENU` varchar(1000) NOT NULL,
  `ART_IMAGE` varchar(50) NOT NULL,
  PRIMARY KEY (`ART_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `t_article`
--

INSERT INTO `t_article` (`ART_ID`, `ART_TITRE`, `ART_DATE`, `ART_DATE_MODIF`, `ART_CONTENU`, `ART_IMAGE`) VALUES
(5, 'test', '2014-10-25 22:00:54', '2014-10-25 22:00:54', 'un texte pas trop long', 'koala.php'),
(6, 'second test', '2014-10-25 22:35:05', '2014-10-25 22:35:05', 'toujours pas plus long', 'koala.php'),
(7, 'essai', '2014-10-25 23:29:07', '2014-10-25 23:29:07', 'un autre essai', 'koala.php');

-- --------------------------------------------------------

--
-- Structure de la table `t_billet`
--

CREATE TABLE IF NOT EXISTS `t_billet` (
  `BIL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BIL_DATE` datetime NOT NULL,
  `BIL_AUTEUR` varchar(15) NOT NULL,
  `BIL_TITRE` varchar(100) NOT NULL,
  `BIL_CONTENU` varchar(400) NOT NULL,
  PRIMARY KEY (`BIL_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `t_billet`
--

INSERT INTO `t_billet` (`BIL_ID`, `BIL_DATE`, `BIL_AUTEUR`, `BIL_TITRE`, `BIL_CONTENU`) VALUES
(1, '2014-09-03 20:52:29', 'bob', 'Premier billet', 'Bonjour monde ! Ceci est le premier billet sur mon blog.'),
(2, '2014-09-03 20:52:29', 'bil', 'Au travail', 'Il faut enrichir ce blog dès maintenant.');

-- --------------------------------------------------------

--
-- Structure de la table `t_commentaire`
--

CREATE TABLE IF NOT EXISTS `t_commentaire` (
  `COM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BIL_ID` int(11) NOT NULL,
  `COM_DATE` datetime NOT NULL,
  `COM_AUTEUR` varchar(20) NOT NULL,
  `COM_CONTENU` varchar(200) NOT NULL,
  PRIMARY KEY (`COM_ID`),
  KEY `fk_com_bil` (`BIL_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Contenu de la table `t_commentaire`
--

INSERT INTO `t_commentaire` (`COM_ID`, `BIL_ID`, `COM_DATE`, `COM_AUTEUR`, `COM_CONTENU`) VALUES
(1, 1, '2014-09-03 20:52:29', 'A. Nonyme', 'Bravo pour ce début'),
(2, 1, '2014-09-03 20:52:29', 'Moi', 'Merci ! Je vais continuer sur ma lancée');

-- --------------------------------------------------------

--
-- Structure de la table `t_commentaire_article`
--

CREATE TABLE IF NOT EXISTS `t_commentaire_article` (
  `ART_ID` int(11) NOT NULL,
  `COM_ART_AUTEUR` varchar(20) NOT NULL,
  `COM_ART_CONTENU` varchar(200) NOT NULL,
  `COM_ART_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COM_ART_ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`COM_ART_ID`),
  KEY `fk_com_art` (`ART_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `t_commentaire_article`
--

INSERT INTO `t_commentaire_article` (`ART_ID`, `COM_ART_AUTEUR`, `COM_ART_CONTENU`, `COM_ART_DATE`, `COM_ART_ID`) VALUES
(6, 'xaalvilo', 'peux faire mieux', '2014-10-28 20:40:59', 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_commentaire`
--
ALTER TABLE `t_commentaire`
  ADD CONSTRAINT `fk_com_bil` FOREIGN KEY (`BIL_ID`) REFERENCES `t_billet` (`BIL_ID`);

--
-- Contraintes pour la table `t_commentaire_article`
--
ALTER TABLE `t_commentaire_article`
  ADD CONSTRAINT `fk_com_art` FOREIGN KEY (`ART_ID`) REFERENCES `t_article` (`ART_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
