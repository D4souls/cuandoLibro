-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-12-2023 a las 16:40:23
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

--
-- Volcado de datos para la tabla `aviso`
--

INSERT INTO `aviso` (`id_aviso`, `tipo`, `comentario`, `dni`, `id_turnoP`) VALUES
(24, 5, 'El trabajador ha salido pronto 00:14:40', '22222222B', 46),
(25, 1, 'El trabajador ha entrado tarde 00:08:12', '11111111A', 47),
(26, 1, 'El trabajador ha entrado tarde 00:15:45', '22222222B', 50),
(27, 5, 'El trabajador ha salido pronto 01:19:50', '22222222B', 50),
(28, 1, 'El trabajador ha entrado tarde 01:00:30', '22222222B', 52),
(29, 5, 'El trabajador ha salido pronto 00:00:01', '22222222B', 54);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(10) NOT NULL,
  `id_departamento` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `sueldo_normal` decimal(9,2) NOT NULL,
  `sueldo_plus` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `id_departamento`, `nombre`, `sueldo_normal`, `sueldo_plus`) VALUES
(2, 2, 'Analista de Pruebas', 12.00, 20.00),
(3, 3, 'Director de Arte', 25.00, 40.00),
(5, 3, 'Diseñador de Experiencia de Usuario (UX)', 15.00, 25.00),
(7, 3, 'Diseñador Gráfico Junior', 12.00, 20.00),
(13, 1, 'Ingeniero de Soporte Técnico', 10.00, 20.00),
(14, 1, 'Desarrollador de Software Junior', 15.00, 25.00),
(15, 1, 'Ingeniero de Sistemas Senior', 25.00, 40.00),
(16, 2, 'Ingeniero de Pruebas Automatizadas', 15.00, 25.00),
(17, 2, 'QA Manager', 25.00, 40.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `presupuesto` decimal(10,2) NOT NULL,
  `gastos` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `nombre`, `presupuesto`, `gastos`) VALUES
(1, 'Ingeniería', 30000.00, 0.00),
(2, 'Testing', 18000.00, 960.00),
(3, 'Diseño', 12000.00, 0.00);

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
  `mail` varchar(80) NOT NULL,
  `n_categoria` int(10) DEFAULT NULL,
  `n_departamento` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`dni`, `nombre`, `apellido1`, `apellido2`, `IBAN`, `mail`, `n_categoria`, `n_departamento`) VALUES
('11111111A', 'José Antonio', 'Ávila', 'Mollón', 'ES123456789', 'joseantonioavila1@gmail.com', 2, 2),
('22222222B', 'Verónica', 'Macho', 'Tojo', 'ES123456789', 'machoveronica@gmail.com', 2, 2),
('33333333C', 'Sergio', 'Ávila', 'Macho', 'ES123123123', 'sergioavilamacho12@gmail.com', 14, 1);

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
  `fecha` date NOT NULL,
  `dni` varchar(9) NOT NULL,
  `total` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nominas`
--

INSERT INTO `nominas` (`id`, `fecha`, `dni`, `total`) VALUES
(1, '0000-00-00', '33333333C', 20),
(6, '2023-12-17', '33333333C', 20);

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
(4, 'Aviso grave'),
(5, 'Salida temprana'),
(6, 'Ausencia sin justificar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id_turno` int(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `plus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id_turno`, `nombre`, `hora_entrada`, `hora_salida`, `plus`) VALUES
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
(45, 2, 2, '2023-12-18', '2023-12-18 05:59:01', '2023-12-18 14:03:27', '11111111A', 1),
(46, 2, 2, '2023-12-18', '2023-12-18 05:59:10', '2023-12-18 13:45:20', '22222222B', 1),
(47, 2, 2, '2023-12-19', '2023-12-19 06:08:12', '2023-12-19 14:30:45', '11111111A', 1),
(48, 2, 2, '2023-12-19', '2023-12-19 06:02:37', '2023-12-19 14:45:20', '22222222B', 1),
(49, 2, 2, '2023-12-20', '2023-12-20 06:01:30', '2023-12-20 14:15:22', '11111111A', 1),
(50, 2, 2, '2023-12-20', '2023-12-20 06:15:45', '2023-12-20 12:40:10', '22222222B', 1),
(51, 2, 2, '2023-12-21', '2023-12-21 06:04:55', '2023-12-21 14:55:40', '11111111A', 1),
(52, 2, 2, '2023-12-21', '2023-12-21 07:00:30', '2023-12-21 15:38:55', '22222222B', 1),
(53, 2, 2, '2023-12-22', '2023-12-22 06:03:17', '2023-12-22 14:00:00', '11111111A', 1),
(54, 2, 2, '2023-12-22', '2023-12-22 06:01:15', '2023-12-22 13:59:59', '22222222B', 1);

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
(1, 'S.Avila', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 2, '33333333C', '2023-12-17 13:56:55', '2023-12-17 00:16:27'),
(45, 'J.Avila', '11111111A', 1, '11111111A', '2023-12-17 13:58:03', NULL),
(46, 'V.Macho', '22222222B', 1, '22222222B', '2023-12-17 13:58:18', NULL);

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
  MODIFY `id_aviso` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `nominas`
--
ALTER TABLE `nominas`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipoaviso`
--
ALTER TABLE `tipoaviso`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id_turno` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `turnos_publicados`
--
ALTER TABLE `turnos_publicados`
  MODIFY `id_turnoP` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `userweb`
--
ALTER TABLE `userweb`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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