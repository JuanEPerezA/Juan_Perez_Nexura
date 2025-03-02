-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2025 a las 21:46:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juan_perez_nexura`
--
CREATE DATABASE IF NOT EXISTS `juan_perez_nexura` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `juan_perez_nexura`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL COMMENT 'Identificador del área',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del área de la empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre`) VALUES
(1, 'Ventas'),
(2, 'Calidad'),
(3, 'Administración'),
(4, 'Producción'),
(5, 'TICs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL COMMENT 'Identificador del empleado',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre completo del empleado',
  `email` varchar(255) NOT NULL COMMENT 'Coorreo electrónico del empleado',
  `sexo` char(11) NOT NULL COMMENT 'M: Masculino, F: Femenino',
  `area_id` int(11) NOT NULL COMMENT 'Área de la empresa a la que pertenece el empleado',
  `boletin` int(11) NOT NULL COMMENT '1: Recibir boletín, 0: No recibir boletín',
  `descripcion` text NOT NULL COMMENT 'Experiencia del empleado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `email`, `sexo`, `area_id`, `boletin`, `descripcion`) VALUES
(1, 'Juan Esteban Pérez Aguas', 'jepa9@hotmail.com', 'M', 5, 0, 'Soy una persona con actitud, aptitud y disposición para trabajar en equipo, caracterizado por ser comprometido, disciplinado, respetuoso, organizado, con adaptabilidad y disposición para el aprendizaje, con gusto por adquirir nuevos conocimientos, o fortalecer los ya adquiridos.\r\nExperiencia en el uso de buenas prácticas de programación: clean code, y metodologías ágiles.\r\nActualmente mis fuertes son: PHP Slim, Twig), React JS, Git, SQL, Y un poco de Node JS/Express.'),
(2, 'Camila Arrieta', 'mcab@hotmail.com', 'F', 3, 0, 'Hola, puedo cumplir varios roles'),
(3, 'Juan Camilo Pérez Arrieta', 'xxx@hotmail.com', 'M', 3, 1, 'Hola, soy una persona con buena actitud y ganas de aprender');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados_rol`
--

CREATE TABLE `empleados_rol` (
  `empleado_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados_rol`
--

INSERT INTO `empleados_rol` (`empleado_id`, `rol_id`) VALUES
(1, 4),
(2, 3),
(2, 2),
(2, 1),
(3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL COMMENT 'Identificador del rol',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del rol'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Auxiliar Administrativo'),
(2, 'Gerente Estratégico'),
(3, 'Profesional de proyectos'),
(4, 'Desarrollador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_id` (`area_id`);

--
-- Indices de la tabla `empleados_rol`
--
ALTER TABLE `empleados_rol`
  ADD KEY `FK_EmpleadoID` (`empleado_id`),
  ADD KEY `FK_RolID` (`rol_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del área', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del empleado', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del rol', AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Filtros para la tabla `empleados_rol`
--
ALTER TABLE `empleados_rol`
  ADD CONSTRAINT `FK_EmpleadoID` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `FK_RolID` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
