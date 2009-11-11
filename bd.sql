-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Lun 02 Février 2009 à 14:35
-- Version du serveur: 5.0.41
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de données: `projet`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `binome`
-- 

CREATE TABLE `binome` (
  `num` int(4) NOT NULL auto_increment,
  `nom1` varchar(50) NOT NULL,
  `nom2` varchar(50) NOT NULL,
  `valide` int(1) default '0',
  `id_proj` int(4) default NULL,
  `niveau` varchar(2) NOT NULL,
  PRIMARY KEY  (`num`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `binome`
-- 

INSERT INTO `binome` (`num`, `nom1`, `nom2`, `valide`, `id_proj`, `niveau`) VALUES 
(4, 'crinier', 'quettier', 1, 1, 'A2');

-- --------------------------------------------------------

-- 
-- Structure de la table `date`
-- 

CREATE TABLE `date` (
  `annee` int(4) NOT NULL,
  `construction_binome` int(20) NOT NULL,
  `enregistrement_projet` int(20) NOT NULL,
  `reunion_coor` int(20) NOT NULL,
  `diffusion_sujet` int(20) NOT NULL,
  `formulation_voeux` int(20) NOT NULL,
  `affectation_sujet` int(20) NOT NULL,
  `rapport_pre` int(20) NOT NULL,
  `remise_rapport` int(20) NOT NULL,
  `deb_soutenance` int(20) NOT NULL,
  `fin_soutenance` int(20) NOT NULL,
  `niveau` varchar(2) NOT NULL,
  PRIMARY KEY  (`annee`,`niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `date`
-- 

INSERT INTO `date` (`annee`, `construction_binome`, `enregistrement_projet`, `reunion_coor`, `diffusion_sujet`, `formulation_voeux`, `affectation_sujet`, `rapport_pre`, `remise_rapport`, `deb_soutenance`, `fin_soutenance`, `niveau`) VALUES 
(0, 946594800, 946594800, 946594800, 946594800, 946594800, 946594800, 946594800, 946594800, 946594800, 946594800, ''),
(2008, 1221040800, 1221127200, 1221132600, 1221199200, 1221732000, 1222077600, 1224496800, 1233313200, 1233730800, 1233939600, 'A2');

-- --------------------------------------------------------

-- 
-- Structure de la table `eleves`
-- 

CREATE TABLE `eleves` (
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `groupe` varchar(2) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pwd` varchar(80) NOT NULL,
  `boolbin` varchar(1) NOT NULL default '0',
  `niveau` varchar(2) NOT NULL,
  PRIMARY KEY  (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `eleves`
-- 

INSERT INTO `eleves` (`nom`, `prenom`, `groupe`, `login`, `pwd`, `boolbin`, `niveau`) VALUES 
('ADDI', 'NORDINE', 'C2', 'addi', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('AKATAY', 'KARIM', 'C4', 'akatay', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('ALESSIO', 'JONATHAN', 'C5', 'alessio', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('ALTASSERRE', 'OLIVIER', 'C3', 'altasserre', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('AMARGER', 'FABIEN', 'C3', 'amarger', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('AMOUROUX', 'JONATHAN', 'C5', 'amouroux', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('AMPHOUX', 'GUILHEM', 'C1', 'amphoux', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BADUEL', 'QUENTIN', 'C4', 'baduel', 'f02368945726d5fc2a14eb576f7276c0', '1', 'A2'),
('BAQUIER', 'DIDIER', 'C3', 'baquier', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BARDY', 'CATHELINE', 'C1', 'bardy', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BARO', 'LUC', 'C2', 'baro', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BAZIN', 'KEVIN', 'C3', 'bazin', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BENEZET', 'THOMAS', 'C4', 'benezet', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BERTHELOT', 'VICTOR', 'C3', 'berthelot', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BERTRAND', 'SEBASTIEN', 'C4', 'bertrand', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BIANCIOTTO', 'FLORENT', 'C5', 'bianciottof', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BIANCIOTTO', 'ROMAIN', 'C1', 'bianciottor', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BILLY', 'MARC', 'C2', 'billy', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BLANC', 'MAXIME', 'C5', 'blanc', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BOEUF', 'FLORIAN', 'C3', 'boeuf', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BONAVERO', 'YOANN', 'C4', 'bonavero', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BOUDJOUHALI', 'SOFIANE', 'C5', 'boudjouhali', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BOUYA', 'EHOLA', 'C2', 'bouya', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BRES', 'YOANN', 'C5', 'bres', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BRETON', 'JIM', 'C3', 'breton', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('BREUIL', 'JONATHAN', 'C4', 'breuil', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CABALLE', 'JULIEN', 'C2', 'caballe', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CAMBIER', 'AUDREY', 'C2', 'cambier', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CAMROUX', 'KEVIN', 'C2', 'camroux', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CARRASCO', 'UGO', 'C2', 'carrasco', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CASABONA', 'GAUTIER', 'C4', 'casabona', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CHAPPERT', 'NICOLAS', 'C2', 'chappert', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CHARDON', 'NICOLAS', 'C3', 'chardon', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CHARMASSON', 'EMILIEN', 'C5', 'charmasson', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CIECKO', 'THOMAS', 'C3', 'ciecko', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CLAVEL', 'ARMAND', 'C1', 'clavel', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('COMA', 'KAVY', 'C2', 'coma', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('COULET', 'MATTHIEU', 'C5', 'coulet', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('COUSEIN', 'KILIAN', 'C3', 'cousein', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('CRINIER', 'ETIENNE', 'C4', 'crinier', 'f02368945726d5fc2a14eb576f7276c0', '1', 'A2'),
('DEJEAN', 'QUENTIN', 'C1', 'dejean', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DELMAS', 'MARINA', 'C1', 'delmas', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DELOBELLE', 'JULIEN', 'C5', 'delobelle', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DIETRICH     ', 'NICOLAS', 'C1', 'dietrich     ', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DOURTHE', 'AYMERIC', 'C4', 'dourthe', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DROSS', 'PIERRE-ANTHONY', 'C1', 'dross', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DUFER    ', 'BENJAMIN', 'C2', 'dufer    ', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DUMAS', 'DAMIEN', 'C5', 'dumas', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DUPONT', 'PHILIPPE', 'C3', 'dupont', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('DUQUENOIS', 'JUDITH', 'C4', 'duquenois', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('ESTEBE', 'ANTHONY', 'C1', 'estebe', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('FARAIL', 'SIMON', 'C2', 'farail', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('FAURE', 'MATHIEU', 'C4', 'faure', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('FELIX', 'MARION', 'C2', 'felix', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('FERRARA', 'FLORIANE', 'C2', 'ferrara', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('FIORENTINO', 'PAUL-ALAIN', 'C4', 'fiorentino', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('FREISS', 'ETIENNE', 'C1', 'freiss', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('GABRIAC', 'JEROME', 'C2', 'gabriac', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('GATTY', 'SEBASTIEN', 'C4', 'gatty', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('GIROD', 'IAN', 'C4', 'girodi', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('GIROD', 'STEPHANE', 'C1', 'girods', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('GOT', 'ALEXANDRE', 'C2', 'got', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('GRAZIOLI', 'ALEXANDRE', 'C5', 'grazioli', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('HOARAU', 'JONATHAN', 'C3', 'hoarau', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('HOCINE', 'SARAH', 'C5', 'hocine', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('HUILLET', 'ALEXANDRA', 'C1', 'huillet', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('JOUANARD', 'FLORIAN', 'C2', 'jouanard', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('KHOUIDER KADDOUR', 'LILA', 'C5', 'khouider', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('KLENIN', 'ALEXEI', 'C1', 'klenin', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('LACOCHE', 'ALEXANDRE', 'C1', 'lacoche', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('LAFONT', 'JULIEN', 'C2', 'lafont', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('LONGEARET', 'BENJAMIN', 'C1', 'longearet', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MARPOT', 'MATHIEU', 'C4', 'marpot', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MARTI', 'JULIE', 'C3', 'marti', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MATTIACI', 'KEVIN', 'C5', 'mattiaci', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MAURIN', 'ADRIAN', 'C2', 'maurin', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MEINNIER', 'FABIEN', 'C5', 'meinnier', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MENARD', 'LAODIS', 'C3', 'menard', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MONTES', 'MORGAN', 'C1', 'montes', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('MORENO', 'ARNAUD', 'C5', 'moreno', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('NABHEEBUCUS', 'SHEZAD', 'C1', 'nabheebucus', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('NIEDERGANG', 'JOACHIM', 'C3', 'niedergang', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('NIVELLE', 'CHRISTOPHE', 'C4', 'nivelle', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('OLIVE     ', 'MATHIEU', 'C1', 'olive     ', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('PALMAROLE', 'LUC', 'C3', 'palmarole', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('PEDRENO', 'HUGUES', 'C5', 'pedreno', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('PEREZ', 'OLIVIER', 'C3', 'perez', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('PERRAUDIN', 'RUDY', 'C4', 'perraudin', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('PISTRE', 'VINCENT', 'C4', 'pistre', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('POUSSOU', 'ANAEL', 'C5', 'poussou', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('PRAVOSSOUDOVITCH', 'YANN', 'C3', 'pravossoudovitch', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('QUETTIER', 'LUCILE', 'C4', 'quettier', 'f02368945726d5fc2a14eb576f7276c0', '1', 'A2'),
('RAMI', 'LEILA', 'C3', 'rami', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('RIGOLLET', 'XAVIER', 'C5', 'rigollet', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('ROBERT', 'THIBAUD', 'C1', 'robert', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('SABATIER', 'PIERRE-ALAIN', 'C3', 'sabatier', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('SCHNEIDER', 'AUDREY', 'C1', 'schneider', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('SEGUIER', 'NICOLAS', 'C1', 'seguier', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('SEGUY', 'ROMAIN', 'C3', 'seguy', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('SEMAAN', 'SEBASTIEN', 'C2', 'semaan', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('TARDIEU', 'BENJAMIN', 'C3', 'tardieu', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('TEIXEIRA', 'JULIEN', 'C3', 'teixeira', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('TENDERO', 'JULIEN', 'C2', 'tendero', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('TERRANOVA', 'DAVID', 'C4', 'terranova', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('THISSE', 'WILLIAM', 'C2', 'thisse', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('TONNERRE', 'ARTHUR', 'C5', 'tonnerre', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('TRIAY', 'MATHIEU', 'C3', 'triay', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VACHER', 'DAMIEN', 'C1', 'vacher', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VALENTIN', 'FABIEN', 'C5', 'valentin', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VERBAL', 'CHRISTOPHER', 'C1', 'verbal', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VERGNES', 'PASCAL', 'C2', 'vergnes', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VERHAEGE', 'FREDERIC', 'C5', 'verhaege', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VERON-DURAND', 'JORIS', 'C2', 'veron-durand', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VIDAL', 'JULIEN', 'C4', 'vidal', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VIGUIE', 'PIERRE', 'C1', 'viguie', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('VILLAIN', 'BENJAMIN', 'C2', 'villain', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('WAGNON', 'ROBIN', 'C3', 'wagnon', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2'),
('WILHELM', 'ROMAN', 'C4', 'wilhelm', 'f02368945726d5fc2a14eb576f7276c0', '0', 'A2');

-- --------------------------------------------------------

-- 
-- Structure de la table `indisponibilite`
-- 

CREATE TABLE `indisponibilite` (
  `login` varchar(30) NOT NULL,
  `lundi` varchar(50) NOT NULL,
  `mardi` varchar(50) NOT NULL,
  `mercredi` varchar(50) NOT NULL,
  `jeudi` varchar(50) NOT NULL,
  `vendredi` varchar(50) NOT NULL,
  PRIMARY KEY  (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `indisponibilite`
-- 

INSERT INTO `indisponibilite` (`login`, `lundi`, `mardi`, `mercredi`, `jeudi`, `vendredi`) VALUES 
('bajard', ';2;3;4;', ';1;2;3;4;5;6;7;9;', ';1;2;3;4;5;6;8;', ';1;2;3;4;5;7;9;', ';2;3;4;'),
('boyat', ';', ';4;', ';3;', ';', ';7;'),
('joubert', ';1;2;3;4;5;6;7;8;9;10;11;', ';1;2;3;4;5;6;7;8;9;10;11;', ';1;2;3;4;5;6;7;8;9;10;11;', ';1;2;3;4;5;6;7;8;9;10;11;', ';1;2;3;4;5;6;7;8;9;10;11;'),
('salmon', ';10;', '', '', '', ';11;');

-- --------------------------------------------------------

-- 
-- Structure de la table `prof`
-- 

CREATE TABLE `prof` (
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `pwd` varchar(80) NOT NULL,
  `droit` int(1) NOT NULL default '0',
  PRIMARY KEY  (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `prof`
-- 

INSERT INTO `prof` (`nom`, `prenom`, `login`, `pwd`, `droit`) VALUES 
('ALBERNHE-GIORDAN', 'Hugette', 'albernhe', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('BAJARD', 'Jean-claude', 'bajard', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('BELLAHSENE', 'Zohra', 'bellahsene', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('BERLINET', 'Alain', 'berlinet', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('BETAILLE', 'Henri', 'betaille', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('BONACHE', 'Adrien', 'bonache', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('BOYAT', 'Jeannine', 'boyat', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('CHAPELLIER', 'Philippe', 'chapellier', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('CHIROUZE', 'Anne', 'chirouze', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('COGIS', 'Olivier', 'cogis', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('COLETTA', 'Rémi', 'coletta', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('CROITORU', 'Madalina', 'croitoru', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('DELPERDANGE', 'Catherine', 'delperdange', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('EGGRICKX', 'Ariel', 'eggrickx', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('GARCIA', 'Francis', 'garcia', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('GENTHIAL', 'Michèle', 'genthial', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('GOUAICH', 'Adbelkader', 'gouaich', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('GUILLEMENET', 'Yoann', 'guillemenet', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('JOANNIDES', 'Marc', 'joannides', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('JOUBERT', 'Alain', 'joubert', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('LACHENY', 'Alain', 'lacheny', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('LIBRES', 'Aline', 'libres', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('MAHE', 'Serge-André', 'mahe', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('MARIE-JEANNE', 'Alain', 'marie-jeanne', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('MAZARS-CHAPELON', 'Agnès', 'mazars', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('METZ', 'Stéphanie', 'metz', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('MICHEL', 'Fabien', 'michel', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('NOUGUIER', 'Bernard', 'nouguier', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('PALAYSI', 'Jérôme', 'palaysi', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('PALLEJA', 'Nathalie', 'pallejaN', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('PALLEJA', 'Xavier', 'pallejaX', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('SABATIER', 'Alain', 'sabatier', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('SALMON', 'Laurence', 'salmon', '9953fff13f73ccea4d5bd709f0b3f083', 1),
('SIMONET', 'Geneviève', 'simonet', '9953fff13f73ccea4d5bd709f0b3f083', 0),
('VALVERDE', 'Irène', 'valverde', '9953fff13f73ccea4d5bd709f0b3f083', 0);

-- --------------------------------------------------------

-- 
-- Structure de la table `projets`
-- 

CREATE TABLE `projets` (
  `id_proj` int(4) NOT NULL auto_increment,
  `tuteur1` varchar(60) NOT NULL,
  `tuteur2` varchar(60) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `binwish` int(1) NOT NULL,
  `binpos` int(1) NOT NULL,
  `description` text NOT NULL,
  `qualif` varchar(100) NOT NULL,
  `dom_appl` text NOT NULL,
  `mat_log` varchar(200) NOT NULL,
  `remarques` text NOT NULL,
  `niveau` varchar(10) NOT NULL,
  PRIMARY KEY  (`id_proj`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Contenu de la table `projets`
-- 

INSERT INTO `projets` (`id_proj`, `tuteur1`, `tuteur2`, `titre`, `binwish`, `binpos`, `description`, `qualif`, `dom_appl`, `mat_log`, `remarques`, `niveau`) VALUES 
(1, 'bajard', '', 'Un petit SSL', 2, 2, 'Le but est de construire une application client serveur de communications sécurisées entre deux ordinateurs. \r\nPour ceci il faudra implanter des algorithmes de cryptographie comme AES, RSA et Diffie Hellman key exchange. \r\nLors d''un dialogue les machines construisent une clef secrète commune via Diffie Hellman puis poursuivent l''echange \r\nvia AES en utilisant cette clef. De plus les machines peuvent s''authentifier avec RSA et une fonction de hachage comme \r\nSha256. ', 'analyse & conception, développement & programmation', 'Programmation en Java', '', 'aucune', 'A2'),
(2, 'bajard', '', 'Compression d''images', 2, 2, 'Le but est de developper une application de compression décompression d''images sur le schéma de JPEG. \r\nPour cela, des algorithmes de transformations 2D de Fourier ou de cosinus seront implantés ainsi que du codage de Huffman. \r\nL''application devra permettre de choisir le taux de compression et d''afficher les images.', 'Analyse & Conception, Développement & Programmation', 'Cette application sera construite en java. ', '', 'aucune', 'A2'),
(3, 'bajard', '', 'Compression de son', 2, 2, 'Ce projet a pour but de compresser et compresser des fichier sonore selon MPEG. \r\nComme pour les images cela demande l''implantation de transformation 1D de Fourier ou cosinus et de codage \r\nde Huffman. \r\nL''application devra permettre de choisir le taux de compression et  de filtrer le son avec un filtre type petit equaliseur. ', 'Analyse & Conception, Développement & Programmation', 'Cette application sera construite en java.', '', 'aucune', 'A2'),
(4, 'betaille', 'chapellier', 'Jeu d’entreprise Exige2', 2, 2, 'Le but de ce projet est de continuer la réécriture du jeu d''entreprise EXIGE actuellement utilisé en deuxième année du département informatique, sous une forme client/serveur pour permettre son utilisation à partir d''un navigateur.  Possibilité de plusieurs jeux simultanés (les 5 groupes de deuxième année doivent pouvoir jouer en parallèle). Trois niveaux d’intervenants :                                                                                                              - administrateur qui effectue la création d’un jeu avec un ou plusieurs arbitres - arbitre qui décide du nombre d’équipes d’un jeu et des valeurs initiales, intervention après les prises de décisions des équipes pour les valider et lancer les calculs pour passer à l’étape suivante - équipes qui fournissent leurs décisions et consultent les résultats des différentes étapes.  Les informations de chaque étape devront être conservées pour permettre un éventuel retour à l’étape précédente.  Ce projet a commencé à être Les sources du jeu sont en PHP      ', ' analyse & conception, développement & programmation, continuation ou maintenance', 'Analyse, Programmation, gestion', 'XHTML, CSS, Base de Données, PHP, apache', 'Ce projet a démarré l’an dernier, il faut repartir de ce qui vient d’être écrit pour vérifier quelques algorithmes (comparaison des résultats avec des jeux des années précédentes) \r\nEnsuite, des fonctionnalités supplémentaires seront à mettre en service.', 'A2'),
(5, 'joubert', 'salmon', 'test', 1, 1, 'tztr', ' analyse & conception, continuation ou maintenance', 'arbo', 'azd', '', 'LP:PGI');

-- --------------------------------------------------------

-- 
-- Structure de la table `soutenance`
-- 

CREATE TABLE `soutenance` (
  `id_bin` int(4) NOT NULL,
  `date` int(10) NOT NULL,
  `salle` int(3) NOT NULL,
  `tuteur_comp` varchar(30) NOT NULL,
  PRIMARY KEY  (`id_bin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `soutenance`
-- 

INSERT INTO `soutenance` (`id_bin`, `date`, `salle`, `tuteur_comp`) VALUES 
(4, 1233730800, 12, ''),
(5, 1233828000, 12, 'genthial');

-- --------------------------------------------------------

-- 
-- Structure de la table `wish`
-- 

CREATE TABLE `wish` (
  `id_bin` int(4) NOT NULL,
  `wish1` int(4) NOT NULL,
  `wish2` int(4) NOT NULL,
  `wish3` int(4) NOT NULL,
  `wish4` int(4) NOT NULL,
  `wish5` int(4) NOT NULL,
  `niveau` varchar(2) NOT NULL,
  PRIMARY KEY  (`id_bin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Contenu de la table `wish`
-- 

INSERT INTO `wish` (`id_bin`, `wish1`, `wish2`, `wish3`, `wish4`, `wish5`, `niveau`) VALUES 
(1, 1, 2, 3, 4, 5, 'A2'),
(2, 1, 3, 2, 5, 4, 'A2'),
(4, 1, 2, 3, 4, 5, 'A2');
