-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2023 a las 20:28:08
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
CREATE DATABASE fichajedb;
USE fichajedb;
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aviso`
--

CREATE TABLE `aviso` (
  `id_aviso` int(9) NOT NULL,
  `tipo` int(9) NOT NULL,
  `comentario` varchar(500) DEFAULT 'No se han proporcionado comentarios',
  `dni` varchar(9) NOT NULL,
  `id_turnoP` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(10) NOT NULL,
  `id_departamento` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sueldo_normal` int(9) NOT NULL,
  `sueldo_plus` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `id_departamento`, `nombre`, `sueldo_normal`, `sueldo_plus`) VALUES
(1, 1, 'Tecnico', 10, 15),
(2, 2, 'Ingeniero', 15, 20),
(3, 3, 'Consultor', 17, 22),
(5, 3, 'Director', 25, 30),
(7, 3, 'Diseñador Junior', 15, 5),
(11, 1, 'prueba', 10, 10),
(12, 1, 'ajsdb', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `presupuesto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre`, `presupuesto`) VALUES
(1, 'Ingenieria', 30000),
(2, 'Testing', 15000),
(3, 'Diseño', 12000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `IBAN` varchar(50) NOT NULL,
  `n_categoria` int(10) DEFAULT NULL,
  `n_departamento` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`dni`, `nombre`, `apellido1`, `apellido2`, `IBAN`, `n_categoria`, `n_departamento`) VALUES
('11111111A', 'Rubén', 'Fernandez', 'Zapatero', 'es12345678', 7, 3),
('12345678H', 'Verónica', 'Macho', 'Tojo', 'PT25905960248248664275964', 2, 2),
('12774250G', 'Jose Antonio', 'Avila', 'Mollon', 'ES1159173965365197454410', 2, 2),
('72210584Z', 'Sergio', 'Avila', 'Macho', 'ES9437684930976379259720', 2, 2);

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

CREATE TABLE `nominas` (
  `id` int(9) NOT NULL,
  `fecha` datetime NOT NULL,
  `dni` varchar(9) NOT NULL,
  `total` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(9) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `tipo`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoaviso`
--

CREATE TABLE `tipoaviso` (
  `id` int(9) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoaviso`
--

INSERT INTO `tipoaviso` (`id`, `nombre`) VALUES
(1, 'Retraso'),
(2, 'Falta injustificada'),
(3, 'Aviso leve'),
(4, 'Aviso grave');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id_turno` int(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_entrada` time NOT NULL,
  `plus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id_turno`, `nombre`, `hora_salida`, `hora_entrada`, `plus`) VALUES
(1, 'Mañana', '06:00:00', '14:00:00', 0),
(2, 'Tarde', '14:00:00', '22:00:00', 0),
(3, 'Noche', '22:00:00', '06:00:00', 1),
(4, 'Fin De Semana', '07:00:00', '15:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos_publicados`
--

CREATE TABLE `turnos_publicados` (
  `id_turnoP` int(9) NOT NULL,
  `categoria` int(9) DEFAULT NULL,
  `departamento` int(9) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_fichaje_entrada` datetime DEFAULT NULL,
  `hora_fichaje_salida` datetime DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `id_turno` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos_publicados`
--

INSERT INTO `turnos_publicados` (`id_turnoP`, `categoria`, `departamento`, `fecha`, `hora_fichaje_entrada`, `hora_fichaje_salida`, `dni`, `id_turno`) VALUES
(2, 2, 2, '2023-11-28', NULL, NULL, '12345678H', 1),
(6, 2, 2, '2023-11-23', NULL, NULL, '72210584Z', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos_publicados_backup`
--

CREATE TABLE `turnos_publicados_backup` (
  `categoria` int(10) DEFAULT NULL,
  `departamento` int(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora_fichaje_entrada` datetime DEFAULT NULL,
  `hora_fichaje_salida` datetime DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `id_turno` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos_publicados_backup`
--

INSERT INTO `turnos_publicados_backup` (`categoria`, `departamento`, `fecha`, `hora_fichaje_entrada`, `hora_fichaje_salida`, `dni`, `id_turno`) VALUES
(1, 1, '2023-11-16', NULL, NULL, '12774250G', 2),
(1, 1, '2023-11-16', NULL, NULL, '72210584Z', 2),
(1, 1, '2023-11-16', NULL, NULL, '12774250G', 2),
(1, 1, '2023-11-16', NULL, NULL, '72210584Z', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `userweb`
--

CREATE TABLE `userweb` (
  `id` int(9) NOT NULL,
  `username` varchar(20) NOT NULL,
  `userpassword` varchar(64) NOT NULL,
  `rol` int(9) NOT NULL,
  `dniusuarioweb` varchar(9) NOT NULL,
  `lastlogout` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lastchangepassword` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `userweb`
--

INSERT INTO `userweb` (`id`, `username`, `userpassword`, `rol`, `dniusuarioweb`, `lastlogout`, `lastchangepassword`) VALUES
(1, 's.avila', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 2, '72210584Z', '2023-11-27 09:55:22', '2023-11-23 11:56:01'),
(8, 'V.Macho', '12345678H', 1, '12345678H', '2023-11-20 09:36:09', NULL),
(9, 'J.Avila', 'a280f9c1266fc6a4aea482b8206f367bbd96a76a075140cd67ef4e92c01e3142', 1, '12774250G', '2023-11-27 09:57:41', '2023-11-23 13:43:06'),
(10, 'R.pito', '11111111A', 1, '11111111A', '2023-11-23 13:56:16', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD PRIMARY KEY (`id_aviso`),
  ADD KEY `dni` (`dni`),
  ADD KEY `id_turnoP` (`id_turnoP`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `id_departamento` (`id_departamento`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`dni`),
  ADD KEY `n_categoria` (`n_categoria`),
  ADD KEY `n_departamento` (`n_departamento`);

--
-- Indices de la tabla `nominas`
--
ALTER TABLE `nominas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni` (`dni`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipoaviso`
--
ALTER TABLE `tipoaviso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id_turno`);

--
-- Indices de la tabla `turnos_publicados`
--
ALTER TABLE `turnos_publicados`
  ADD PRIMARY KEY (`id_turnoP`),
  ADD KEY `dni` (`dni`),
  ADD KEY `id_turno` (`id_turno`),
  ADD KEY `fk_category` (`categoria`),
  ADD KEY `fk_department` (`departamento`);

--
-- Indices de la tabla `userweb`
--
ALTER TABLE `userweb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`),
  ADD KEY `dniusuarioweb` (`dniusuarioweb`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aviso`
--
ALTER TABLE `aviso`
  MODIFY `id_aviso` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `nominas`
--
ALTER TABLE `nominas`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipoaviso`
--
ALTER TABLE `tipoaviso`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id_turno` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `turnos_publicados`
--
ALTER TABLE `turnos_publicados`
  MODIFY `id_turnoP` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `userweb`
--
ALTER TABLE `userweb`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
