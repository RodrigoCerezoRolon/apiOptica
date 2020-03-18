-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2020 a las 14:29:59
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `opticabd`
--
CREATE DATABASE IF NOT EXISTS `opticabd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `opticabd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anteojos`
--

CREATE TABLE `anteojos` (
  `id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `aumento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `anteojos`
--

INSERT INTO `anteojos` (`id`, `color`, `marca`, `precio`, `aumento`) VALUES
(1, 'blanco', 'citroen', 3000, 4),
(2, 'gris', 'renault', 6500, 9),
(3, 'negro', 'ford', 4200, 1),
(4, 'rojo', 'asd', 2000, 3),
(5, 'azul', 'negra', 1500, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` varchar(50) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `clave`, `nombre`, `apellido`, `perfil`, `foto`) VALUES
(1, 'empleado@empleado.com', '123456', 'empleado', 'perez', 'empleado', ''),
(2, 'encargado@encargado.com.ar', '123456', 'encargado', 'gonzalez', 'encargado', ''),
(4, 'asd@asd.com', 'asd', 'juan', 'perez', 'propietario', 'Desert.jpg'),
(5, 'j@p.com', '123', 'juan', 'perez', 'propietario', 'Koala.jpg'),
(6, 'cosme@fulanito.com', '3456', 'cosme', 'fulanito', 'empleado', 'Penguins.jpg'),
(7, 'cosme@fulanito.com', '3456', 'cosme', 'fulanito', 'empleado', 'Lighthouse.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_anteojos`
--

CREATE TABLE `ventas_anteojos` (
  `id` int(11) NOT NULL,
  `id_anteojos` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas_anteojos`
--

INSERT INTO `ventas_anteojos` (`id`, `id_anteojos`, `cantidad`, `fecha`) VALUES
(1, 2, 5, '09/12/2019'),
(2, 3, 2, '08/12/2019'),
(3, 1, 1, '30/11/2019'),
(4, 3, 4, '06/12/2019'),
(5, 5, 2, '09/12/2019'),
(6, 6, 2, '02/3/20'),
(7, 6, 2, '02/3/22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anteojos`
--
ALTER TABLE `anteojos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas_anteojos`
--
ALTER TABLE `ventas_anteojos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anteojos`
--
ALTER TABLE `anteojos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas_anteojos`
--
ALTER TABLE `ventas_anteojos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
