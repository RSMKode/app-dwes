-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2024 a las 21:49:43
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
(4, 'Mañanas'),
(5, 'Tardes'),
(9, 'Noches');

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
(4, 9);

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
(2, 'Valenciano'),
(3, 'Inglés');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicios` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` int(11) NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  `foto_servicio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicios`, `titulo`, `id_user`, `descripcion`, `precio`, `tipo`, `foto_servicio`) VALUES
(1, 'Servicio Admin', 1, 'Servicio de prueba de admin', 10, 1, ''),
(2, 'Servicio MIAU', 31, 'MIAUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUU', 1, 0, ''),
(4, 'Admin II', 1, 'QUIERO DINERO', 100, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens`
--

CREATE TABLE `tokens` (
  `token` varchar(128) NOT NULL,
  `validez` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tokens`
--

INSERT INTO `tokens` (`token`, `validez`, `id_user`) VALUES
('65baa470df8e0', 86400, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user-idioma`
--

CREATE TABLE `user-idioma` (
  `id_user` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `descripción` varchar(300) NOT NULL,
  `nivel` smallint(6) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_user`, `nombre`, `email`, `pass`, `f_nacimiento`, `foto_perfil`, `descripción`, `nivel`, `activo`) VALUES
(1, 'ADMIN', 'admin@admin.com', '$2y$10$AkdyGuiYrBVP5llBbb5PSOTF05F5KAO.R8Ccz7QSOAbYS6EUyNFE2', '1998-01-26', 'src\\images\\users\\1706296786Thor.jpg', 'Admin', 2, 0),
(31, 'Miau', 'miau@gmail.com', '$2y$10$deC.Fp9rJtXCViaFqHbnROUZ7rCD1ire3q8ekyLOqG2W/r8bpB3bq', '2000-01-26', '', 'Miau', 1, 0),
(35, 'Guau', 'guau@gmail.com', '$2y$10$xaCCI9d7UF8pXYaEsQeduOtZ86ekqNoSbvN9OVcQ8ttl.0qqAG9ya', '2000-01-26', '', 'GUAU', 1, 0),
(38, 'prueba', 'prueba@gmail.com', '$2y$10$9fzHUqmMDCOQQ2dFhVbIWeJViYfv3CV9UkClXL8Y5ZznoSUZIu02W', '1999-01-31', '', 'prueba', 1, 0);

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
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicios`);

--
-- Indices de la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `user-idioma`
--
ALTER TABLE `user-idioma`
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
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `idioma`
--
ALTER TABLE `idioma`
  MODIFY `id_idioma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `disp_servicio`
--
ALTER TABLE `disp_servicio`
  ADD CONSTRAINT `fk_iddisponibilidad` FOREIGN KEY (`id_disponibilidad`) REFERENCES `disponibilidad` (`id_disponibilidad`),
  ADD CONSTRAINT `fk_idservicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicios`);

--
-- Filtros para la tabla `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`);

--
-- Filtros para la tabla `user-idioma`
--
ALTER TABLE `user-idioma`
  ADD CONSTRAINT `fk_ididioma` FOREIGN KEY (`id_idioma`) REFERENCES `idioma` (`id_idioma`),
  ADD CONSTRAINT `fk_iduser` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
