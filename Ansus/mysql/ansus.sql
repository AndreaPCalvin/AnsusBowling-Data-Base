-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2020 a las 13:14:54
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ansus`
--
CREATE DATABASE IF NOT EXISTS `ansus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ansus`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bolera`
--

CREATE TABLE IF NOT EXISTS `bolera` (
  `id_bolera` int(4) NOT NULL,
  `num_pistas` int(2) NOT NULL,
  `calle` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `cp` int(5) NOT NULL,
  `telefono` int(9) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_bolera`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `cp` (`cp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `bolera`
--

INSERT INTO `bolera` (`id_bolera`, `num_pistas`, `calle`, `cp`, `telefono`, `nombre`) VALUES
(1, 12, 'Calle patata 27', 45600, 123456789, 'La bolera Original'),
(2, 7, 'Calle Tomate', 28522, 123123123, 'Bowling Masters'),
(3, 15, 'Avenida Salmón', 28850, 989898989, 'MC Bowling'),
(4, 15, 'Calle Alcachofa', 37002, 963963963, 'La salamantesa'),
(5, 9, 'Calle Lechuga', 15706, 987951963, 'Santiago bowling'),
(6, 22, 'Avenida del Pepino', 28231, 951951964, 'PJLO Land'),
(7, 30, 'Calle falsa', 28800, 999666999, 'nepostojeće'),
(8, 10, 'Calle de la Lubina', 28100, 323232323, 'Fun&Joy'),
(9, 20, 'Avenida del Perejil', 28500, 987654321, 'The King of Bowling'),
(10, 30, 'Plaza de la Patata', 28003, 687543012, 'La Macrobolera'),
(11, 15, 'Calle del Spaghetti', 28013, 999111777, 'La Bolo-ñesa'),
(12, 16, 'Paseo del Filete de Pollo', 28042, 695432881, 'La Bolera Chirimbolo'),
(13, 12, 'Calle del Coco', 30001, 111222333, 'Cocobolo'),
(14, 10, 'Plaza de la Chapata', 33740, 123654978, 'The Rustik Bowling');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE IF NOT EXISTS `reservas` (
  `id_reserva` int(9) NOT NULL,
  `id_usuario` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `zapatos` tinyint(1) NOT NULL,
  `id_bolera` int(4) NOT NULL,
  `num_personas` int(2) NOT NULL,
  `precio` int(2) NOT NULL,
  `dia` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_pista` (`id_bolera`),
  KEY `id_usuario_2` (`id_usuario`),
  KEY `id_bolera` (`id_bolera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `zapatos`, `id_bolera`, `num_personas`, `precio`, `dia`, `hora_inicio`, `hora_fin`) VALUES
(1, '12345678A', 0, 1, 9, 90, '2020-05-09', '20:00:00', '22:00:00'),
(2, '12345612B', 1, 1, 10, 270, '2020-05-27', '10:00:00', '16:00:00'),
(3, '12345678A', 0, 2, 2, 22, '2020-06-29', '09:00:00', '09:30:00'),
(4, '12345678A', 0, 6, 4, 112, '2020-06-11', '20:00:00', '22:30:00'),
(5, '12345678A', 0, 6, 8, 45, '2020-06-20', '13:00:00', '14:00:00'),
(6, '96380012Z', 1, 7, 1, 22, '2020-06-30', '10:00:00', '10:30:00'),
(7, '96380012Z', 1, 7, 6, 292, '2020-07-07', '16:00:00', '22:30:00'),
(8, '96380012Z', 1, 1, 10, 247, '2020-07-24', '18:00:00', '23:30:00'),
(9, '96380012Z', 1, 4, 4, 225, '2020-06-08', '15:00:00', '20:00:00'),
(10, '96380012Z', 0, 1, 1, 45, '2020-06-30', '11:00:00', '12:00:00'),
(11, '98765432P', 1, 1, 5, 157, '2020-05-31', '10:30:00', '14:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE IF NOT EXISTS `tallas` (
  `id_reserva` int(9) NOT NULL,
  `talla` int(2) NOT NULL,
  `unidades` int(2) NOT NULL,
  PRIMARY KEY (`id_reserva`,`talla`),
  KEY `id_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id_reserva`, `talla`, `unidades`) VALUES
(6, 40, 1),
(7, 33, 2),
(7, 35, 1),
(7, 37, 1),
(7, 40, 1),
(8, 35, 2),
(8, 38, 3),
(8, 40, 3),
(8, 44, 1),
(8, 49, 1),
(9, 34, 3),
(9, 40, 1),
(11, 35, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE IF NOT EXISTS `ubicacion` (
  `CP` int(5) NOT NULL,
  `ciudad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`CP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`CP`, `ciudad`, `provincia`) VALUES
(15706, 'Santiago', 'Coruña'),
(28003, 'Madrid', 'Madrid'),
(28013, 'Madrid', 'Madrid'),
(28042, 'Madrid', 'Madrid'),
(28100, 'Alcobendas', 'Madrid'),
(28231, 'Las Rozas', 'Madrid'),
(28500, 'Arganda del Rey', 'Madrid'),
(28522, 'Rivas-Vaciamadrid', 'Madrid'),
(28800, 'Alcalá de Henares', 'Madrid'),
(28850, 'Torrejón de Ardoz', 'Madrid'),
(30001, 'Murcia', 'Murcia'),
(33740, 'Tapia de Casariego', 'Asturias'),
(37002, 'Salamanca', 'Salamanca'),
(45600, 'Talavera de la Reina', 'Toledo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `DNI` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_usuario` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(9) NOT NULL,
  `contrasena` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`DNI`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`DNI`, `nombre_usuario`, `nombre`, `apellidos`, `telefono`, `contrasena`) VALUES
('04866143x', 'Pepe', 'Juan', 'Sanchez', 695111461, '$2y$10$W2xv5qOhqXIQ4EAdh3my1uUp77ZkMmu0s0e3g8bEGN/sAOudGxBm6'),
('12345612B', 'jesuss07', 'Jesús', 'Sanchez', 695111461, '$2y$10$/0arULuINhPkD.Hzh/7HhuNNmSP2x2YWCkAmaetzXYyjubQrTIl2i'),
('12345678A', 'Andrea', 'Andrea', 'Peña', 633633633, '$2y$10$hCfIHBqFaXZrmObd43OEQ.zNTrdiwFFk1JCxnT3IC367yefB/uJWW'),
('96380012Z', 'JuanPa', 'Juan', 'Palomo', 695111461, '$2y$10$spK1czeoF2N6M5VVoznAeOwuohfYJfN2z2Rwuk50YFk2MQaydC9iC'),
('98765432P', 'Pacman', 'Paco', 'Gómez', 666666666, '$2y$10$KWyg2qh7ZOJ4/O1F4X4nCObMcJaMuSOUfraB3Lby8mA.VtaSAvKe2'),
('99977754G', 'Aurora27', 'Aurora', 'Lopez', 111222333, '$2y$10$vfR420yT/.SxxVI5pdQI8OTRTA.t0Mvex85rry7lYx4X3x6.0TzQO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zapatos`
--

CREATE TABLE IF NOT EXISTS `zapatos` (
  `id_reserva` int(9) NOT NULL,
  `num_zapatos` int(2) NOT NULL,
  `coste` int(3) NOT NULL,
  PRIMARY KEY (`id_reserva`),
  KEY `id_reserva` (`id_reserva`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `zapatos`
--

INSERT INTO `zapatos` (`id_reserva`, `num_zapatos`, `coste`) VALUES
(6, 1, 2),
(7, 5, 10),
(8, 10, 20),
(9, 4, 8),
(11, 1, 2);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bolera`
--
ALTER TABLE `bolera`
  ADD CONSTRAINT `bolera_ibfk_1` FOREIGN KEY (`cp`) REFERENCES `ubicacion` (`CP`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_bolera`) REFERENCES `bolera` (`id_bolera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD CONSTRAINT `tallas_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `zapatos` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `zapatos`
--
ALTER TABLE `zapatos`
  ADD CONSTRAINT `zapatos_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
