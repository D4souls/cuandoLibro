-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2023 a las 15:19:46
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
-- Base de datos: `fichajedb`
--
CREATE DATABASE IF NOT EXISTS `fichajedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fichajedb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aviso`
--

CREATE TABLE IF NOT EXISTS `aviso` (
  `id_aviso` int(9) NOT NULL AUTO_INCREMENT,
  `tipo` int(9) NOT NULL,
  `comentario` varchar(500) DEFAULT 'No se han proporcionado comentarios',
  `dni` varchar(9) NOT NULL,
  `id_turnoP` int(9) NOT NULL,
  PRIMARY KEY (`id_aviso`),
  KEY `dni` (`dni`),
  KEY `id_turnoP` (`id_turnoP`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(10) NOT NULL AUTO_INCREMENT,
  `id_departamento` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sueldo_normal` int(9) NOT NULL,
  `sueldo_plus` int(9) NOT NULL,
  PRIMARY KEY (`id_categoria`),
  KEY `id_departamento` (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id_departamento` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `presupuesto` int(10) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `IBAN` varchar(50) NOT NULL,
  `n_categoria` int(10) DEFAULT NULL,
  `n_departamento` int(10) DEFAULT NULL,
  PRIMARY KEY (`dni`),
  KEY `n_categoria` (`n_categoria`),
  KEY `n_departamento` (`n_departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `empleados`
--
DELIMITER $$
CREATE TRIGGER `crear_usuarioWeb` AFTER INSERT ON `empleados` FOR EACH ROW BEGIN
	DECLARE new_trabajador VARCHAR(50);
    DECLARE password_trabajador VARCHAR(50);
    
    SET new_trabajador = CONCAT(LEFT(NEW.nombre, 1),".", NEW.apellido1);
    SET password_trabajador = NEW.dni;
    
    INSERT INTO userweb (username, userpassword, rol, dniusuarioweb) VALUES(new_trabajador, password_trabajador, 1, NEW.dni);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nominas`
--

CREATE TABLE IF NOT EXISTS `nominas` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `dni` varchar(9) NOT NULL,
  `total` int(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dni` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoaviso`
--

CREATE TABLE IF NOT EXISTS `tipoaviso` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE IF NOT EXISTS `turnos` (
  `id_turno` int(9) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_entrada` time NOT NULL,
  `plus` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos_publicados`
--

CREATE TABLE IF NOT EXISTS `turnos_publicados` (
  `id_turnoP` int(9) NOT NULL AUTO_INCREMENT,
  `categoria` int(9) DEFAULT NULL,
  `departamento` int(9) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_fichaje_entrada` datetime DEFAULT NULL,
  `hora_fichaje_salida` datetime DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `id_turno` int(9) NOT NULL,
  PRIMARY KEY (`id_turnoP`),
  KEY `dni` (`dni`),
  KEY `id_turno` (`id_turno`),
  KEY `fk_category` (`categoria`),
  KEY `fk_department` (`departamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userweb`
--

CREATE TABLE IF NOT EXISTS `userweb` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `userpassword` varchar(50) NOT NULL,
  `rol` int(9) NOT NULL,
  `dniusuarioweb` varchar(9) NOT NULL,
  `lastlogin` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `rol` (`rol`),
  KEY `dniusuarioweb` (`dniusuarioweb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD CONSTRAINT `aviso_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `empleados` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aviso_ibfk_2` FOREIGN KEY (`id_turnoP`) REFERENCES `turnos_publicados` (`id_turnoP`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `aviso_ibfk_3` FOREIGN KEY (`tipo`) REFERENCES `tipoaviso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`n_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`n_departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `nominas`
--
ALTER TABLE `nominas`
  ADD CONSTRAINT `nominas_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `empleados` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `turnos_publicados`
--
ALTER TABLE `turnos_publicados`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`departamento`) REFERENCES `departamentos` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `turnos_publicados_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `empleados` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `turnos_publicados_ibfk_2` FOREIGN KEY (`id_turno`) REFERENCES `turnos` (`id_turno`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `userweb`
--
ALTER TABLE `userweb`
  ADD CONSTRAINT `userweb_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userweb_ibfk_2` FOREIGN KEY (`dniusuarioweb`) REFERENCES `empleados` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
