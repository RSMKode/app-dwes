-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2024 a las 21:16:04
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `evaluable_7w`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int(11) NOT NULL,
  `disponibilidad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `disponibilidad`
--

INSERT INTO `disponibilidad` (`id_disponibilidad`, `disponibilidad`) VALUES
(1, 'Mañanas'),
(2, 'Tardes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disp_servicio`
--

CREATE TABLE `disp_servicio` (
  `id_servicio` int(11) NOT NULL,
  `id_disponibilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `disp_servicio`
--

INSERT INTO `disp_servicio` (`id_servicio`, `id_disponibilidad`) VALUES
(3, 1),
(7, 1),
(7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idioma`
--

CREATE TABLE `idioma` (
  `id_idioma` int(11) NOT NULL,
  `idioma` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `idioma`
--

INSERT INTO `idioma` (`id_idioma`, `idioma`) VALUES
(1, 'Castellano'),
(2, 'Inglés');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` int(11) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `foto_servicio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `titulo`, `id_user`, `descripcion`, `precio`, `tipo`, `foto_servicio`) VALUES
(3, 'PianitosSchool', 26, 'de samfrost y rsmkode', 100000, 2, ''),
(6, 'asdas', 26, '', 12, 1, ''),
(7, 'asdasdsadsdads', 26, 'asdsadsa', 1111111, 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `token` varchar(128) NOT NULL,
  `validez` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_idioma`
--

CREATE TABLE `user_idioma` (
  `id_user` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `user_idioma`
--

INSERT INTO `user_idioma` (`id_user`, `id_idioma`) VALUES
(26, 2),
(27, 2),
(28, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `f_nacimiento` date NOT NULL,
  `foto_perfil` varchar(100) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `nivel` smallint(6) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `nombre`, `email`, `pass`, `f_nacimiento`, `foto_perfil`, `descripcion`, `nivel`, `activo`) VALUES
(26, 'Miau', 'miau@gmail.com', '$2y$10$6PYCbeJcJB3hhLffTa14quBTKMZRaSUx0ViG7A2XHUvoL2K1xR3By', '1999-10-10', '', 'miasudsad', 1, 0),
(27, 'guau', 'guau@gmail.com', '$2y$10$DCyYsXlUHF/9fBf2OHAd.upvPsB/nzujGb5wcKVoOVOwFKUJXxdGa', '1999-01-10', 'src\\images\\users\\1704893053caballos.jpg', 'guau', 1, 0),
(28, 'Lidia', 'lidia@gmail.com', '$2y$10$S3pjGYtblUVwUSfgAn1a5.T6Mb9odwSWvUN6AQk8rFzscBnjmm4oC', '2000-06-06', 'src\\images\\users\\Thor.jpg', 'Hola soy Lidia', 1, 0),
(29, 'nyan', 'nyan@gmail.com', '$2y$10$WvnE3xYC8I60RPVT90vB8OKRSIwvc08aSePpezvTXmqf/6CegbVj2', '1999-01-16', '', 'nyan', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD PRIMARY KEY (`id_disponibilidad`);

--
-- Indices de la tabla `disp_servicio`
--
ALTER TABLE `disp_servicio`
  ADD PRIMARY KEY (`id_servicio`,`id_disponibilidad`),
  ADD KEY `fk_iddisponibilidad` (`id_disponibilidad`);

--
-- Indices de la tabla `idioma`
--
ALTER TABLE `idioma`
  ADD UNIQUE KEY `id_idioma` (`id_idioma`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `user_idioma`
--
ALTER TABLE `user_idioma`
  ADD PRIMARY KEY (`id_user`,`id_idioma`),
  ADD KEY `fk_ididioma` (`id_idioma`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uq_email_usuario` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `idioma`
--
ALTER TABLE `idioma`
  MODIFY `id_idioma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `disp_servicio`
--
ALTER TABLE `disp_servicio`
  ADD CONSTRAINT `fk_iddisponibilidad` FOREIGN KEY (`id_disponibilidad`) REFERENCES `disponibilidad` (`id_disponibilidad`),
  ADD CONSTRAINT `fk_idservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`);

--
-- Filtros para la tabla `user_idioma`
--
ALTER TABLE `user_idioma`
  ADD CONSTRAINT `fk_ididioma` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`),
  ADD CONSTRAINT `fk_iduser` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
