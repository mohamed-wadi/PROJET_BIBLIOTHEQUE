`auteur` (
  `id_auteur` int(11) NOT NULL,
  `nom_auteur` varchar(17) DEFAULT NULL,
  `prenom_auteur` varchar(17) DEFAULT NULL
)
`buy` (
  `id_buy` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `date_buy` timestamp NOT NULL DEFAULT current_timestamp()
)
`client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(17) NOT NULL,
  `prenom_client` varchar(17) NOT NULL,
  `genre` varchar(10) NOT NULL,
  `Email` varchar(75) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `country` text DEFAULT NULL,
  `Nb_emprunt` int(11) DEFAULT 0,
  `Date_inscription` date DEFAULT NULL,
  `MDP` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` varchar(15) DEFAULT 'client'
)
`commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `date_commentaire` timestamp NOT NULL DEFAULT current_timestamp(),
  `stars` int(11) NOT NULL DEFAULT 20,
  `Helpful` int(11) NOT NULL DEFAULT 0,
  `Unhelpful` int(11) NOT NULL DEFAULT 0
)
`email_subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscription_date` timestamp NOT NULL DEFAULT current_timestamp()
)
`evaluation` (
  `id_evaluation` int(11) NOT NULL,
  `ISBN` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL
)
`genre_livre` (
  `id_genre` int(11) NOT NULL,
  `nom_genre` varchar(50) NOT NULL
)
`livre` (
  `ISBN` int(11) NOT NULL,
  `titre_livre` varchar(70) NOT NULL,
  `id_genre` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT 1,
  `img_livre` text NOT NULL,
  `Emplacement` text NOT NULL,
  `Paragraphe` text NOT NULL,
  `prix` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reduction` decimal(5,2) NOT NULL DEFAULT 0.00,
  `Date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `langue` varchar(255) DEFAULT NULL,
  `date_publication` date NOT NULL DEFAULT current_timestamp()
)
`request` (
  `id_request` int(11) NOT NULL,
  `name_client` varchar(255) NOT NULL,
  `email_client` varchar(255) NOT NULL,
  `phone_client` int(13) DEFAULT NULL,
  `subject_request` varchar(255) DEFAULT NULL,
  `message_request` varchar(1000) NOT NULL,
  `date_request` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
)
`shoppingcart` (
  `cart_id` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)
`visitor` (
  `id` int(11) NOT NULL,
  `browser_name` varchar(255) NOT NULL,
  `browser_version` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
)
`vote_commentaire` (
  `id_commentaire` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `Helpful` tinyint(1) NOT NULL DEFAULT 0,
  `Unhelpful` tinyint(1) NOT NULL DEFAULT 0
)
`wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `ISBN` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
)