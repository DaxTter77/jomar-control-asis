-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-08-2019 a las 19:35:09
-- Versión del servidor: 10.3.15-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_asis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `id_estado` varchar(20) NOT NULL DEFAULT '01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `nombres`, `apellidos`, `correo`, `usuario`, `clave`, `id_estado`) VALUES
('01', 'Developer', 'Jomar', 'aprendiz@jomar.com.co', '01', '12345', '01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` varchar(20) NOT NULL,
  `asistencia` varchar(100) NOT NULL,
  `siglas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`id_asistencia`, `asistencia`, `siglas`) VALUES
('09', 'De Permiso', 'DP'),
('04', 'Descanso', 'DC'),
('03', 'Hora Extra', 'HE'),
('05', 'Incapacidad', 'IN'),
('02', 'Medio Tiempo', 'MT'),
('07', 'No Evidencia', 'NE'),
('06', 'Retirado', 'RT'),
('08', 'Suspendido', 'SUSP'),
('01', 'Tiempo Completo', 'TC'),
('10', 'Vacaciones', 'VAC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` varchar(20) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `id_estado` varchar(20) NOT NULL DEFAULT '01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `cargo`, `id_estado`) VALUES
('01', 'Lider de Gestion Humana', '01'),
('02', 'Gerente', '01'),
('03', 'Lider de Mercadeo', '01'),
('04', 'Lider de Tesoreria', '01'),
('05', 'Lider I+D', '01'),
('06', 'Auxiliar Administrativo', '01'),
('07', 'Aprendiz', '01'),
('08', 'Auxiliar de Cocina', '01'),
('09', 'Maestra de Cocina', '01'),
('10', 'Auxiliar de Producción', '01'),
('11', 'Operario de Producción', '01'),
('12', 'Mesero', '01'),
('13', 'Oficios varios', '01'),
('14', 'Cajero', '01'),
('15', 'Administrador', '01'),
('16', 'Cocina', '01'),
('17', 'Lavado', '01'),
('18', 'Auxiliar Operativo', '01'),
('19', 'Administrativo', '01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_asistencias`
--

CREATE TABLE `control_asistencias` (
  `id_controlAsis` varchar(20) NOT NULL,
  `fecha` date NOT NULL,
  `id_empleado` varchar(20) NOT NULL,
  `id_asistencia` varchar(20) NOT NULL,
  `id_admin` varchar(20) NOT NULL,
  `nota` varchar(100) NOT NULL,
  `id_estado` varchar(20) NOT NULL DEFAULT '01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` varchar(20) NOT NULL,
  `documento` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `id_sede` varchar(20) NOT NULL,
  `id_cargo` varchar(20) NOT NULL,
  `id_estado` varchar(20) NOT NULL DEFAULT '01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `documento`, `nombres`, `apellidos`, `id_sede`, `id_cargo`, `id_estado`) VALUES
('01', '6550199', 'Manuel ', 'Chará', '04', '01', '01'),
('02', '1005868476', 'Jesika ', 'Miranda Mayorga', '02', '08', '01'),
('03', '38595206', 'Diana Paola', 'Duque', '02', '15', '01'),
('04', '1107090262', 'Daniela ', 'Sanchez Calderon', '02', '09', '01'),
('05', '1058787630', 'Maribel', 'Ordoñez', '02', '12', '01'),
('06', '94074192', 'Andres Felipe', 'Lopez', '02', '12', '01'),
('07', '1107100909', 'Brayan David', 'Forero', '02', '14', '01'),
('08', '1143975251', 'Deisy', 'Velasquez', '02', '16', '01'),
('09', '31531397', 'Angela Maria', 'Valencia', '02', '16', '01'),
('10', '1144081994', 'Diego Fernando ', 'Vinasco', '02', '12', '01'),
('11', '1115079109', 'Nathaly ', 'Gonzalez Naranjo', '02', '12', '01'),
('12', '35590542', 'Alba Luz', 'Palacios', '02', '08', '01'),
('13', '26315271', 'Ana Eneida', 'Cordoba', '02', '09', '01'),
('14', '1075022878', 'Yulenni', 'Murillo Mosquera', '01', '08', '01'),
('15', '1004603686', 'Rosa Clemencia', 'Ceballos', '01', '09', '01'),
('16', '31988892', 'Doris', 'Quintero', '01', '17', '01'),
('17', '67033930', 'Yssela', 'Alegria', '01', '08', '01'),
('18', '1062275780', 'Alix Clarena', 'Carabalí', '01', '08', '01'),
('19', '1130611575', 'Didier Antonio', 'Astudillo', '01', '12', '01'),
('20', '67026392', 'Luisa Fernanda', 'Valencia', '01', '12', '01'),
('21', '1234191507', 'Luis', 'Cartagena', '01', '12', '01'),
('22', '1143867364', 'Steven', 'Restrepo Espinosa', '01', '12', '01'),
('23', '1199062318', 'William Andres', 'Vinasco', '01', '12', '01'),
('24', '31320869', 'Durley Astrid', 'Masmela', '01', '15', '01'),
('25', '67031912', 'Nury', 'Rivera Trujillo', '01', '08', '01'),
('26', '1143842635', 'Gabriel', 'Caballero Bedoya', '04', '06', '01'),
('27', '31309960', 'Dellanira', 'Ortiz Solis', '01', '09', '01'),
('28', '31997303', 'Mariela', 'Florez Angulo', '01', '12', '01'),
('29', '1090432048', 'Andres Felipe', 'Capote', '01', '12', '01'),
('30', '66316168', 'Neisa', 'Asprilla Rivas', '01', '08', '01'),
('31', '26303825', 'Nuris Maria', 'Cordoba', '01', '09', '01'),
('32', '1143845680', 'Ingrid Yurany', 'Bravo', '02', '13', '01'),
('33', '1113524125', 'Jonatan', 'Escobar Rodriguez', '02', '12', '01'),
('34', '31962372', 'Adriana', 'Gonzalez Lopez', '02', '13', '01'),
('35', '1143944110', 'Karen Lizeth', 'Torres', '04', '04', '01'),
('36', '1006049257', 'Maria Isabel', 'Mejia', '03', '07', '01'),
('37', '110706816', 'Yuli Patricia', 'Ortiz', '03', '11', '01'),
('38', '1143974595', 'Daniel Francisco', 'Riascos', '03', '07', '01'),
('39', '1144065689', 'Juan Manuel', 'Astudillo', '04', '02', '01'),
('40', '1143969583', 'Karen Sofia', 'Garcia', '04', '03', '01'),
('41', '1144197292', 'Daniel Mauricio', 'Olave', '01', '08', '01'),
('42', '1005872456', 'Dylan', 'Restrepo Calvache', '04', '07', '01'),
('43', '31308902', 'Liliana', 'Solarte Memandez', '03', '10', '01'),
('44', '48657354', 'Carmen Maria', 'Carabali', '02', '09', '01'),
('45', '1130625514', 'Anderson', 'Ruiz', '04', '05', '01'),
('46', '16845310', 'Ronald Andres', 'Astudillo', '03', '18', '01'),
('47', '1005867166', 'Yomari', 'Miranda Mayorga', '01', '15', '01'),
('48', '1118310717', 'Juan Felipe', 'Bonilla', '04', '19', '01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` varchar(20) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `estado`) VALUES
('01', 'activo'),
('02', 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sede`
--

CREATE TABLE `sede` (
  `id_sede` varchar(20) NOT NULL,
  `sede` varchar(100) NOT NULL,
  `id_estado` varchar(20) NOT NULL DEFAULT '01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sede`
--

INSERT INTO `sede` (`id_sede`, `sede`, `id_estado`) VALUES
('01', 'Fogón del Mar', '01'),
('02', 'Picaro Cangrejo', '01'),
('03', 'Distrimar', '01'),
('04', 'Jomar', '01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `fk_idEstado2` (`id_estado`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD UNIQUE KEY `asistencia` (`asistencia`,`siglas`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`),
  ADD KEY `fk_idEstado4` (`id_estado`);

--
-- Indices de la tabla `control_asistencias`
--
ALTER TABLE `control_asistencias`
  ADD PRIMARY KEY (`id_controlAsis`),
  ADD KEY `fk_idEmpleado2` (`id_empleado`),
  ADD KEY `fk_idAsistencia2` (`id_asistencia`),
  ADD KEY `fk_idAdmin2` (`id_admin`),
  ADD KEY `fk_idEstado6` (`id_estado`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `fk_idEstado5` (`id_estado`),
  ADD KEY `fk_idSede2` (`id_sede`),
  ADD KEY `fk_idCargo2` (`id_cargo`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `sede`
--
ALTER TABLE `sede`
  ADD PRIMARY KEY (`id_sede`),
  ADD KEY `fk_idEstado3` (`id_estado`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `fk_idEstado2` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `fk_idEstado4` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `control_asistencias`
--
ALTER TABLE `control_asistencias`
  ADD CONSTRAINT `fk_idAdmin2` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`),
  ADD CONSTRAINT `fk_idAsistencia2` FOREIGN KEY (`id_asistencia`) REFERENCES `asistencia` (`id_asistencia`),
  ADD CONSTRAINT `fk_idEmpleado2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `fk_idEstado6` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_idCargo2` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
  ADD CONSTRAINT `fk_idEstado5` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `fk_idSede2` FOREIGN KEY (`id_sede`) REFERENCES `sede` (`id_sede`);

--
-- Filtros para la tabla `sede`
--
ALTER TABLE `sede`
  ADD CONSTRAINT `fk_idEstado3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
