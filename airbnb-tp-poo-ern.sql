-- --------------------------------------------------------

-- Hôte:                         127.0.0.1

-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)

-- SE du serveur:                Win64

-- HeidiSQL Version:             11.2.0.6213

-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET NAMES utf8 */

;

/*!50503 SET NAMES utf8mb4 */

;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */

;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */

;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */

;

-- Listage de la structure de la base pour airbnb-tp

-- Listage de la structure de la table airbnb-tp. equipement

DROP TABLE IF EXISTS `equipement`;

CREATE TABLE
    IF NOT EXISTS `equipement` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `label` varchar(150) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8;

-- Listage des données de la table airbnb-tp.equipement

/*!40000 ALTER TABLE `equipement` DISABLE KEYS */

;

INSERT INTO
    `equipement` (`id`, `label`)
VALUES (1, 'Cuisine équipée'), (2, 'Parking gratuit'), (3, 'Wifi'), (4, 'Télévision'), (5, 'Piscine privée'), (6, 'Lave-linge'), (7, 'Sèche-linge'), (8, 'Baignoire'), (9, 'Animaux acceptés'), (10, 'Draps');

/*!40000 ALTER TABLE `equipement` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. type_logement

DROP TABLE IF EXISTS `type_logement`;

CREATE TABLE
    IF NOT EXISTS `type_logement` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `label` varchar(150) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8;

-- Listage des données de la table airbnb-tp.type_logement

/*!40000 ALTER TABLE `type_logement` DISABLE KEYS */

;

INSERT INTO
    `type_logement` (`id`, `label`)
VALUES (1, 'Logement entier'), (2, 'Chambre privée'), (3, 'Chambre partagée'), (4, 'Maisons troglodytes'), (5, 'Cabanes perchées'), (6, 'Design'), (7, 'Sur l\'eau'), (8, 'Grandes demeures'), (9, 'Wow!'), (10, 'Maisons en container');

/*!40000 ALTER TABLE `type_logement` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. adresse

DROP TABLE IF EXISTS `adresse`;

CREATE TABLE
    IF NOT EXISTS `adresse` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `rue` varchar(150) NOT NULL,
        `code_postal` varchar(10) NOT NULL,
        `ville` varchar(150) NOT NULL,
        `pays` varchar(150) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8;

-- Listage des données de la table airbnb-tp.adresse

/*!40000 ALTER TABLE `adresse` DISABLE KEYS */

;

INSERT INTO
    `adresse` (
        `id`,
        `rue`,
        `code_postal`,
        `ville`,
        `pays`
    )
VALUES (
        1,
        '2, allée des Primevères',
        '54840',
        'Velaine-en-Haye',
        'France'
    );

/*!40000 ALTER TABLE `adresse` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. utilisateur

DROP TABLE IF EXISTS `utilisateur`;

CREATE TABLE
    IF NOT EXISTS `utilisateur` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `mot_de_passe` varchar(255) NOT NULL,
        `is_annonceur` BOOLEAN NOT NULL,
        `adresse_id` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `adresse_id` (`adresse_id`),
        FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`id`)
    );

-- Listage des données de la table airbnb-tp.utilisateur : ~0 rows (environ)

/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */

;

INSERT INTO
    `utilisateur` (
        `id`,
        `email`,
        `mot_de_passe`,
        `is_annonceur`,
        `adresse_id`
    )
VALUES (
        1,
        'toto@toto.com',
        'e2774105b64eeb7efb28a23e407054b060dcb9de068dcc9bbfa9091f165508bf00bda8b74b9e181065945da9b62ce201d16020d1361d2bd0727a3524397d6fbb',
        TRUE,
        1
    ), (
        2,
        'doe@doe.com',
        '0e160bbc55e512064a50280e7edcf24ce89102f84be499bd3e3ca1c159158a544ca941f6372df53dedfbf52cf75cec75bbec05cea480fec7a825ad85e8cdacd3',
        FALSE,
        1
    );

/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. annonce

DROP TABLE IF EXISTS `annonce`;

CREATE TABLE
    IF NOT EXISTS `annonce` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `titre` varchar(255) NOT NULL,
        `adresse_id` int(10) NOT NULL,
        `utilisateur_id` int(10) NOT NULL,
        `prix` int(10) NOT NULL,
        `type_logement_id` int(10) NOT NULL,
        `taille` int(10) NOT NULL,
        `nb_pieces` int(10) NOT NULL,
        `description` varchar(255) NOT NULL,
        `nb_couchages` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `adresse_id` (`adresse_id`),
        KEY `utilisateur_id` (`utilisateur_id`),
        KEY `type_logement_id` (`type_logement_id`),
        FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`id`),
        FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`),
        FOREIGN KEY (`type_logement_id`) REFERENCES `type_logement` (`id`)
    );

-- Listage des données de la table airbnb-tp.annonce : ~0 rows (environ)

/*!40000 ALTER TABLE `annonce` DISABLE KEYS */

;

INSERT INTO
    `annonce` (
        `id`,
        `titre`,
        `adresse_id`,
        `utilisateur_id`,
        `prix`,
        `type_logement_id`,
        `taille`,
        `nb_pieces`,
        `description`,
        `nb_couchages`
    )
VALUES (
        1,
        'Mon super logement',
        1,
        1,
        150,
        1,
        300,
        12,
        'Maison entière sur deux étages avec jardin et petite piscine. Le tout dans un quartier calme en pleine campagne en lorraine. Idéal pour les amateurs de calme et de ballades en forêt.',
        10
    );

/*!40000 ALTER TABLE `annonce` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. reservation

DROP TABLE IF EXISTS `reservation`;

CREATE TABLE
    IF NOT EXISTS `reservation` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `annonce_id` int(10) NOT NULL,
        `utilisateur_id` int(10) NOT NULL,
        `date_debut` DATETIME NOT NULL,
        `date_fin` DATETIME NOT NULL,
        PRIMARY KEY (`id`),
        KEY `annonce_id` (`annonce_id`),
        KEY `utilisateur_id` (`utilisateur_id`),
        CONSTRAINT `FK1_annonce` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`),
        CONSTRAINT `FK2_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`)
    );

-- Listage des données de la table airbnb-tp.reservation : ~0 rows (environ)

/*!40000 ALTER TABLE `reservation` DISABLE KEYS */

;

INSERT INTO
    `reservation` (
        `id`,
        `annonce_id`,
        `utilisateur_id`,
        `date_debut`,
        `date_fin`
    )
VALUES (
        1,
        1,
        1,
        '2023-09-10 00:00:00',
        '2023-09-14 00:00:00'
    );

/*!40000 ALTER TABLE `reservation` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. photo

DROP TABLE IF EXISTS `photo`;

CREATE TABLE
    IF NOT EXISTS `photo` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `image_path` varchar(150) NOT NULL,
        `annonce_id` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `annonce_id` (`annonce_id`),
        FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`)
    );

-- Listage des données de la table airbnb-tp.photo

/*!40000 ALTER TABLE `photo` DISABLE KEYS */

;

INSERT INTO
    `photo` (
        `id`,
        `image_path`,
        `annonce_id`
    )
VALUES (1, 'mon-logement.jpg', 1);

/*!40000 ALTER TABLE `photo` ENABLE KEYS */

;

-- Listage de la structure de la table airbnb-tp. annonce_equipement (table de maping)

DROP TABLE IF EXISTS `annonce_equipement`;

CREATE TABLE
    IF NOT EXISTS `annonce_equipement` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `annonce_id` int(10) NOT NULL,
        `equipement_id` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `annonce_id` (`annonce_id`),
        KEY `equipement_id` (`equipement_id`),
        FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id`),
        FOREIGN KEY (`equipement_id`) REFERENCES `equipement` (`id`)
    );

-- Listage des données de la table airbnb-tp.annonce_equipement

/*!40000 ALTER TABLE `annonce_equipement` DISABLE KEYS */

;

INSERT INTO
    `annonce_equipement` (
        `id`,
        `annonce_id`,
        `equipement_id`
    )
VALUES (1, 1, 1);

/*!40000 ALTER TABLE `annonce_equipement` ENABLE KEYS */

;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */

;

/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */

;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */

;