SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- No me es posible crear el usuario desde el script por internos del motor MySQL/MariaDB. El servidor devuelve errores #1034 y 
-- #1030 (Error 176 – checksum incorrecto en Aria), lo que hay una corrupción en tablas del sistema en mysql.global_priv. Al estar dañadas 
-- las tablas internas de privilegios, MySQL no puede procesar correctamente el comando CREATE USER, aunque el script sea válido.

-- CREATE DATABASE IF NOT EXISTS gamehub
--   CHARACTER SET utf8mb4
--   COLLATE utf8mb4_unicode_ci;

-- USE gamehub;

-- CREATE USER IF NOT EXISTS 'gamehub_user'@'localhost'
-- IDENTIFIED BY 'gamehub_password';

-- GRANT SELECT, INSERT, UPDATE, DELETE
-- ON gamehub.*
-- TO 'gamehub_user'@'localhost';

-- FLUSH PRIVILEGES;


CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260114163535', '2026-01-14 17:35:42', 59),
('DoctrineMigrations\\Version20260114194003', '2026-01-14 20:40:37', 11),
('DoctrineMigrations\\Version20260115164033', '2026-01-15 17:40:41', 390),
('DoctrineMigrations\\Version20260115170554', '2026-01-15 18:06:10', 12),
('DoctrineMigrations\\Version20260116181231', '2026-01-16 19:12:41', 313),
('DoctrineMigrations\\Version20260118192437', '2026-01-18 20:25:33', 24),
('DoctrineMigrations\\Version20260121214634', '2026-01-21 22:46:40', 375);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `event_date` datetime NOT NULL,
  `organizer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `event_date`, `organizer_id`) VALUES
(1, 'pruaba evento', 'evento evento evento', '2026-01-21 00:00:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_games`
--

CREATE TABLE `event_games` (
  `event_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `event_games`
--

INSERT INTO `event_games` (`event_id`, `game_id`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `game`
--

INSERT INTO `game` (`id`, `title`, `description`, `image`, `year`, `created_at`, `user_id`, `price`) VALUES
(2, 'Eldenring con dlc', 'un mundo magico donde todos te quieren matar y tu haces el rol de la victima', 'c8ed6a5c42241ec0d4d12515d40848ad.jpg', 2022, '2026-01-15 19:44:07', 1, '30.00'),
(4, 'God of war ragnarok', 'kratos se pega con dioses nordicos', '69751f36b492b.jpg', 2018, '2026-01-19 19:55:27', 2, '29.90'),
(5, 'juego prueba 1', 'rgrgrgredh', '7dd389b7744c77cade1a8d67591c72fb.jpg', 2022, '2026-01-19 21:05:35', 3, '30.00'),
(6, 'witcher 3', 'Buen juego 10/10', '76e68a3649ed59a9c1c6e27a98916ea8.jpg', 2002, '2026-01-24 20:53:56', 5, '29.90'),
(7, 'Max Payne', 'La hostia de juego de verdad lo recomiendo', '60c5b5d581dc28c217eb3a927d3f1f7c.jpg', 2012, '2026-01-24 20:55:43', 5, '29.90'),
(8, 'Red Dead Redemption 2', 'Juego de vaqueros matando gente', '7286e8152c881046bbee4663b4ce29d7.jpg', 2018, '2026-01-24 20:59:44', 6, '29.90');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game_genre`
--

CREATE TABLE `game_genre` (
  `game_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `game_genre`
--

INSERT INTO `game_genre` (`game_id`, `genre_id`) VALUES
(2, 1),
(2, 2),
(4, 1),
(4, 3),
(5, 7),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 13),
(7, 15),
(8, 1),
(8, 2),
(8, 13),
(8, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Acción'),
(5, 'ARPG'),
(2, 'Aventura'),
(11, 'Carreras'),
(10, 'Deportes'),
(6, 'Estrategia'),
(7, 'Estrategia en tiempo real'),
(8, 'Estrategia por turnos'),
(19, 'Indie'),
(4, 'JRPG'),
(20, 'Multijugador'),
(12, 'Plataformas'),
(18, 'Puzzle'),
(3, 'RPG'),
(13, 'Shooter'),
(14, 'Shooter en primera persona'),
(15, 'Shooter en tercera persona'),
(9, 'Simulación'),
(16, 'Survival'),
(17, 'Survival Horror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `purchased_at` datetime NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `purchase`
--

INSERT INTO `purchase` (`id`, `price`, `purchased_at`, `buyer_id`, `game_id`) VALUES
(3, '30.00', '2026-01-19 21:06:02', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `avatar`) VALUES
(1, 'juan@mail.com', '[\"ROLE_USER\"]', '$2y$13$ViQCW1OX7QHYiUXJZbo.Zeo4IEnUY0MNyovxm17YlLU.QJ8WjFSC2', 'juan', '82751eb475a817ed19efca81b2e5a4a2.jpg'),
(2, 'admin@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$HcfuXK3qorg4cvLn8Q33MOga3GUwwqgiOb1f1jpgkS9KE5I8j2Yv2', 'admin', '070477343309760dff935728a5878a94.jpg'),
(3, 'erik.avagyan2001@gmail.com', '[\"ROLE_USER\"]', '$2y$13$vVQqVR/hfZ5JyBmHzlZ0yuL6/WhV9Wxx3wDKrc1dAZKBne9nj5bze', 'erik', 'default.jpg'),
(4, 'admin', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$2y$13$UfuG9fs/7acIphcHR.vvOeLcB2xoKV4PKM/3bsXLsX2JMEjBvQTHC', 'admin', 'default.jpg'),
(5, 'isra@mail.com', '[\"ROLE_USER\"]', '$2y$13$KneQgAKR/FxwMqv7eBnzROGYhUzcLBxBpw604jTyEBWp5atFoRqRO', 'israel', 'default.jpg'),
(6, 'mario@mail.com', '[\"ROLE_USER\"]', '$2y$13$2rwAMl7VdBUAZWz2emxoMOLFq11t2hrYyiHbw5kF8VmIlXruvMAvC', 'Mario', 'default.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3BAE0AA7876C4DDA` (`organizer_id`);

--
-- Indices de la tabla `event_games`
--
ALTER TABLE `event_games`
  ADD PRIMARY KEY (`event_id`,`game_id`),
  ADD KEY `IDX_BE389A1D71F7E88B` (`event_id`),
  ADD KEY `IDX_BE389A1DE48FD905` (`game_id`);

--
-- Indices de la tabla `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_232B318CA76ED395` (`user_id`);

--
-- Indices de la tabla `game_genre`
--
ALTER TABLE `game_genre`
  ADD PRIMARY KEY (`game_id`,`genre_id`),
  ADD KEY `IDX_B1634A77E48FD905` (`game_id`),
  ADD KEY `IDX_B1634A774296D31F` (`genre_id`);

--
-- Indices de la tabla `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_835033F85E237E06` (`name`);

--
-- Indices de la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6117D13BE48FD905` (`game_id`),
  ADD KEY `IDX_6117D13B6C755722` (`buyer_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_3BAE0AA7876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `event_games`
--
ALTER TABLE `event_games`
  ADD CONSTRAINT `FK_BE389A1D71F7E88B` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BE389A1DE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `FK_232B318CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `game_genre`
--
ALTER TABLE `game_genre`
  ADD CONSTRAINT `FK_B1634A774296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B1634A77E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_6117D13B6C755722` FOREIGN KEY (`buyer_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6117D13BE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
