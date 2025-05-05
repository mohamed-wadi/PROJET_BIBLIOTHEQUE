-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 28 juin 2024 à 17:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shm`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `id_auteur` int(11) NOT NULL,
  `nom_auteur` varchar(17) DEFAULT NULL,
  `prenom_auteur` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id_auteur`, `nom_auteur`, `prenom_auteur`) VALUES
(21113680, 'Lahiri', 'Jhumpa'),
(41528348, 'خليل', 'عادل محمد '),
(47266077, 'T. Kiyosaki', 'Robert'),
(68409182, 'Crouch', 'Blake'),
(81630361, 'Najib', 'Ahmad'),
(84480520, 'Logan', 'A.R');

-- --------------------------------------------------------

--
-- Structure de la table `book_review`
--

CREATE TABLE `book_review` (
  `review_id` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `rating_client` int(1) NOT NULL DEFAULT 3,
  `rating_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book_review`
--

INSERT INTO `book_review` (`review_id`, `ISBN`, `id_client`, `rating_client`, `rating_date`) VALUES
(37, 20294442, 21566856, 3, '2024-03-10'),
(38, 20294442, 21566856, 5, '2024-03-10'),
(39, 20294442, 21566856, 2, '2024-03-10'),
(40, 20294442, 21566856, 3, '2024-03-10'),
(41, 20294442, 21566856, 1, '2024-03-10'),
(42, 20294442, 21566856, 4, '2024-03-10'),
(43, 20294442, 21566856, 4, '2024-03-10'),
(44, 20294442, 21566856, 5, '2024-03-10'),
(45, 20294442, 21566856, 5, '2024-03-10'),
(46, 20294442, 21566856, 5, '2024-03-10'),
(47, 20294442, 21566856, 1, '2024-03-10'),
(48, 20294442, 80217996, 1, '2024-03-17'),
(49, 20294442, 80217996, 4, '2024-03-17'),
(50, 22119017, 80217996, 5, '2024-03-22');

-- --------------------------------------------------------

--
-- Structure de la table `buy`
--

CREATE TABLE `buy` (
  `id_buy` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date_buy` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `buy`
--

INSERT INTO `buy` (`id_buy`, `id_client`, `ISBN`, `price`, `date_buy`) VALUES
(41, 18562193, 70294353, 10.00, '2024-03-09 11:10:41'),
(42, 18562193, 22119017, 4.00, '2024-03-09 11:11:01'),
(46, 18562193, 70294353, 0.00, '2024-03-09 23:27:46'),
(47, 18562193, 70294353, 12.00, '2024-01-01 15:40:58'),
(48, 18562193, 22119017, 13.00, '2024-02-02 15:40:58'),
(49, 18562193, 70294353, 34.00, '2024-04-02 14:40:58'),
(50, 18562193, 70294353, 32.00, '2024-05-02 14:40:58'),
(51, 18562193, 22119017, 44.00, '2024-06-02 14:40:58'),
(52, 18562193, 70294353, 22.00, '2024-07-02 14:40:58'),
(53, 18562193, 70294353, 2.00, '2024-08-02 14:40:58'),
(54, 18562193, 22119017, 11.00, '2024-09-02 14:40:58'),
(55, 18562193, 22119017, 44.00, '2024-10-02 14:40:58'),
(56, 18562193, 22119017, 55.00, '2024-11-02 15:40:58'),
(57, 18562193, 27410647, 33.00, '2024-12-02 15:40:58');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(17) NOT NULL,
  `prenom_client` varchar(17) NOT NULL,
  `genre` varchar(10) NOT NULL,
  `Email` varchar(75) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `country` text DEFAULT NULL,
  `Date_inscription` date NOT NULL DEFAULT current_timestamp(),
  `MDP` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` varchar(15) DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom_client`, `prenom_client`, `genre`, `Email`, `date_naissance`, `country`, `Date_inscription`, `MDP`, `phone`, `role`) VALUES
(18562193, 'BELKADI', 'HAMZA', 'man', 'hamzabelkadi25@gmail.com', '2003-09-01', 'MA', '2024-03-09', 'eGT7lBvLoq', '679084271', 'admin'),
(21566856, 'hamza', 'belkadi', 'man', 'issamouahidi3@gmail.com', '2024-03-02', 'AF', '2024-03-09', 'PuDQo0FaLk', '600000000', 'client'),
(80217996, 'HID', 'DEN', 'man', 'logogenius9@gmail.com', '2006-02-02', 'MA', '2024-03-16', 'Admin12345', '0000000000', 'client');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `date_commentaire` timestamp NOT NULL DEFAULT current_timestamp(),
  `Helpful` int(11) NOT NULL DEFAULT 0,
  `Unhelpful` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_client`, `ISBN`, `commentaire`, `date_commentaire`, `Helpful`, `Unhelpful`) VALUES
(84, 18562193, 70294353, 'XSH', '2024-03-09 23:25:01', 0, 0),
(85, 21566856, 20294442, 'GOOD', '2024-03-09 23:25:19', 1, 0),
(86, 21566856, 20294442, 'good book', '2024-03-09 23:40:14', 1, 0),
(87, 80217996, 22119017, 'good', '2024-03-22 22:02:14', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `email_subscribers`
--

CREATE TABLE `email_subscribers` (
  `id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscription_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `ISBN` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `titre_livre` varchar(70) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT 1,
  `img_livre` text NOT NULL,
  `Emplacement` text NOT NULL,
  `Paragraphe` text NOT NULL,
  `prix` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reduction` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `langue` varchar(255) NOT NULL DEFAULT 'AR',
  `date_publication` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`ISBN`, `id_auteur`, `titre_livre`, `genre`, `etat`, `img_livre`, `Emplacement`, `Paragraphe`, `prix`, `reduction`, `Date_added`, `langue`, `date_publication`) VALUES
(20294442, 47266077, 'Père riche, père pauvre', 'Financial', 1, 'book/img_livree/Père_riche,père_pauvre.jpg', 'book/Emplacement/shm.pdf', '\\\"Père riche, Père pauvre\\\" revolutionizes established financial notions, demonstrating that lasting wealth isn\\\'t solely dependent on high incomes. Challenging the conventional notion that a house is an asset, it urges a reconsideration of our financial priorities. By highlighting the shortcomings of traditional education in money matters, it encourages parents to teach their children essential financial principles. This edition offers nine study session sections to enrich your understanding and facilitate discussions with fellow readers.', 10.00, 0.00, '2024-03-09 22:21:59', 'FR', '2017-12-01'),
(22119017, 21113680, 'Histoires Romaines', 'Science Fiction', 1, 'book/img_livree/Roman Stories .jpg', 'book/Emplacement/shm.pdf', 'Histoires Romaines de Jhumpa Lahiri offre un regard saisissant sur la vie à Rome à travers neuf nouvelles captivantes. Dans ce recueil, Lahiri nous transporte dans les rues sinueuses de la capitale italienne, explorant les vies complexes et les rencontres poignantes de ses personnages. Avec une écriture exquise et une perception aiguisée, elle aborde des thèmes universels tels que l\'identité, l\'appartenance et la quête de sens. À travers ces histoires, Lahiri nous invite à réfléchir sur les expériences humaines profondes, tout en capturant l\'essence de Rome d\'une manière authentique et émouvante.', 2.00, 0.00, '2024-03-09 21:29:35', 'FR', '2024-02-12'),
(27410647, 84480520, 'So... How Often Do You Think About The Roman Empire', 'Romance', 1, 'book/img_livree/So... How Often Do You Think About The Roman Empire Emperors, Gladiators, Strategies Of War- The Ultimate 300 Question Quiz Book, Test your Knowledge ... Between The Rise And Fall Of Ancient Rome..jpg', 'book/Emplacement/shm.pdf', 'Plongez dans l\'histoire fascinante de l\'Empire romain avec \"How often do you think about the Roman Empire?\". Ce livre captivant regorge de 2000 faits captivants, récits étonnants et personnages intrigants, offrant un voyage inoubliable à travers l\'Antiquité. Idéal pour les passionnés d\'histoire et les curieux de tous âges, c\'est un cadeau parfait pour explorer l\'héritage durable de Rome.', 2.00, 10.00, '2024-03-09 21:30:45', 'ENG', '2024-02-12'),
(47854984, 41528348, 'أول مرة أتدبر القرآن', 'Science Fiction', 1, 'book/img_livree/اول_مرة_اتدبر_القران.jpg', 'book/Emplacement/أول مرة أتدبر القرآن دليلك لفهم وتدبر القرآن من سورة الفاتحة إلى سورة الناس.pdf', 'دليلك لفهم وتدبر القرآن من سورة الفاتحة إلى سورة الناس ', 1.00, 0.00, '2024-03-09 21:31:35', 'AR', '2024-02-12'),
(70294353, 21113680, 'Dark Matter', 'Science Fiction', 1, 'book/img_livree/Dark Matter- A Novel.jpg', 'book/Emplacement/shm.pdf', 'dark', 10.00, 80.00, '2024-03-09 21:31:35', 'ENG', '2024-02-12'),
(93953816, 81630361, 'أدب الأطفال علم وفن', 'Science Fiction', 1, 'book/img_livree/22ed1e01e9dfb6876cfd79bcb1825dad.png.webp', 'book/Emplacement/أدب الأطفال علم وفن 3.pdf', 'كتاب أدب الأطفال علم وفن تأليف أحمد نجيب، ويشتمل على 5 فصول هامة، الفصل الأول بعنوان: الإطار العام لفن الكتابة للأطفال، وفيه يحدثنا عن: لمن نكتب؟ وماذا نكتب؟ وكيف نكتب؟ ويسلط الضوء في الفصل الثاني على عدد من الاعتبارات التربوية والسيكلوجية مثل مراحل النمو عند الأطفال وعلاقتها بخصائصهم النفسية، واللغة في أدب الأطفال، وموقف الأطفال من الأعمال الأدبية والفنية، ودور القصة في بناء شخصية الطفل وفي الفصل الثالث يحدثنا عن بعض الاعتبارات الأدبية، مثل القواعد الأساسية لكتابة القصة والدراما والشعر، والفصل الرابع يتناول الاعتبارات الفنية والتكنيكية، وهنا يحدثنا عن أهمية دور الوسيط بين الأدب والأطفال، وأهم الوسطاء هم: كتب الأطفال، صحف الأطفال، الإذاعة والتليفزيون، المسرح البشري ومسرح العرائس، الفيلم السينمائي، الأسطوانة.والفصل الخامس والأخير من الكتاب يتناول بعض القضايا المتصلة بأدب الأطفال، مثل تبسيط مؤلفات الكبار، والتقنين في أدب الأطفال، والكتابة للأطفال بأسلوب المجسم، والتخطيط في دنيا الأطفال، ويشتمل الكتاب على عدد من الملاحق مثل نموذج لتقرير فحص الكتب بالإدارة العامة للمكتبات المدرسية، وعدد من الملاحق الأخرى الهامة.', 5.00, 10.00, '2024-03-09 21:31:35', 'AR', '2024-02-12');

-- --------------------------------------------------------

--
-- Structure de la table `request`
--

CREATE TABLE `request` (
  `id_request` int(11) NOT NULL,
  `name_client` varchar(255) NOT NULL,
  `email_client` varchar(255) NOT NULL,
  `phone_client` int(13) DEFAULT NULL,
  `subject_request` varchar(255) DEFAULT NULL,
  `message_request` varchar(1000) NOT NULL,
  `date_request` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `request`
--

INSERT INTO `request` (`id_request`, `name_client`, `email_client`, `phone_client`, `subject_request`, `message_request`, `date_request`) VALUES
(2, 'hamza', 'hamzabelkadi25@gmail.com', NULL, NULL, 'i want to help me in login because my email is...', '2024-02-29 23:00:00'),
(3, 'hamza belkadi', 'hamzabelkadi25@gmail.com', 600000000, 'acount', 'i want to delete my acount ', '2024-03-05 11:19:19'),
(4, 'hamza belkadi', 'hamzabelkadi25@gmail.com', 600000000, 'acount', 'i want to delete my acount ', '2024-03-05 11:20:19');

-- --------------------------------------------------------

--
-- Structure de la table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `cart_id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `shoppingcart`
--

INSERT INTO `shoppingcart` (`cart_id`, `id_client`, `ISBN`, `price`, `created_at`) VALUES
(103, 21566856, 20294442, 10.00, '2024-03-09 23:29:59'),
(104, 80217996, 20294442, 10.00, '2024-03-17 15:33:26');

-- --------------------------------------------------------

--
-- Structure de la table `vote_commentaire`
--

CREATE TABLE `vote_commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `Helpful` tinyint(1) NOT NULL DEFAULT 0,
  `Unhelpful` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vote_commentaire`
--

INSERT INTO `vote_commentaire` (`id_commentaire`, `id_client`, `Helpful`, `Unhelpful`) VALUES
(85, 21566856, 1, 0),
(86, 21566856, 1, 0),
(87, 80217996, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `ISBN` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `id_client`, `ISBN`, `created_at`) VALUES
(32, 21566856, 20294442, '2024-03-09 23:30:42');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id_auteur`);

--
-- Index pour la table `book_review`
--
ALTER TABLE `book_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `book_review_client_fk` (`id_client`),
  ADD KEY `book_review_ibfk_1` (`ISBN`) USING BTREE;

--
-- Index pour la table `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`id_buy`),
  ADD KEY `buy_ibfk_1` (`id_client`),
  ADD KEY `ISBN` (`ISBN`) USING BTREE;

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `commentaire_ibfk_1` (`id_client`),
  ADD KEY `commentaire_ibfk_2` (`ISBN`);

--
-- Index pour la table `email_subscribers`
--
ALTER TABLE `email_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `id_auteur` (`id_auteur`);

--
-- Index pour la table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_request`);

--
-- Index pour la table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `shoppingcart_client_fk` (`id_client`),
  ADD KEY `ISBN` (`ISBN`) USING BTREE;

--
-- Index pour la table `vote_commentaire`
--
ALTER TABLE `vote_commentaire`
  ADD PRIMARY KEY (`id_commentaire`,`id_client`),
  ADD KEY `vote_commentaire_ibfk_2` (`id_client`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `wishlist_client_fk` (`id_client`),
  ADD KEY `ISBN` (`ISBN`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id_auteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91735826;

--
-- AUTO_INCREMENT pour la table `book_review`
--
ALTER TABLE `book_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `buy`
--
ALTER TABLE `buy`
  MODIFY `id_buy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT pour la table `email_subscribers`
--
ALTER TABLE `email_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `ISBN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93953817;

--
-- AUTO_INCREMENT pour la table `request`
--
ALTER TABLE `request`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book_review`
--
ALTER TABLE `book_review`
  ADD CONSTRAINT `book_review_client_fk` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_review_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`);

--
-- Contraintes pour la table `buy`
--
ALTER TABLE `buy`
  ADD CONSTRAINT `buy_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `buy_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`) ON DELETE CASCADE;

--
-- Contraintes pour la table `email_subscribers`
--
ALTER TABLE `email_subscribers`
  ADD CONSTRAINT `email_subscribers_client_fk` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`id_auteur`) REFERENCES `auteur` (`id_auteur`);

--
-- Contraintes pour la table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD CONSTRAINT `shoppingcart_client_fk` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `shoppingcart_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`);

--
-- Contraintes pour la table `vote_commentaire`
--
ALTER TABLE `vote_commentaire`
  ADD CONSTRAINT `vote_commentaire_ibfk_1` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaire` (`id_commentaire`) ON DELETE CASCADE,
  ADD CONSTRAINT `vote_commentaire_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_client_fk` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
