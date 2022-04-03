-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 03, 2022 at 03:14 AM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id18717606_climasys`
--

-- --------------------------------------------------------

--
-- Table structure for table `acceso`
--

CREATE TABLE `acceso` (
  `cod_acceso` int(11) NOT NULL,
  `cod_modulo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `acciones` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `acceso`
--

INSERT INTO `acceso` (`cod_acceso`, `cod_modulo`, `cod_usuario`, `acciones`) VALUES
(1, 'M07', 1, 'CUD'),
(2, 'M13', 1, 'CUD'),
(3, 'M01', 1, 'CUD'),
(4, 'M02', 1, 'CUD'),
(5, 'M03', 1, 'CUD'),
(6, 'M04', 1, 'CUD'),
(7, 'M05', 1, 'CUDP'),
(8, 'M06', 1, 'CUD'),
(9, 'M08', 1, 'CUD'),
(10, 'M09', 1, 'CUD'),
(11, 'M10', 1, 'CUD'),
(12, 'M11', 1, 'CUDP'),
(13, 'M12', 1, 'CUD'),
(14, 'M11', 2, 'CUDP'),
(15, 'M12', 2, 'CUD'),
(16, 'M05', 2, 'CUDP');

-- --------------------------------------------------------

--
-- Table structure for table `bitacora`
--

CREATE TABLE `bitacora` (
  `cod_bitacora` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_modulo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `evento` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bitacora`
--

INSERT INTO `bitacora` (`cod_bitacora`, `cod_usuario`, `cod_modulo`, `fecha`, `evento`) VALUES
(1, 1, 'M07', '2022-04-01 23:14:15', 'Creacion de acceso'),
(2, 1, 'M07', '2022-04-01 23:14:20', 'Creacion de acceso'),
(3, 1, 'M07', '2022-04-01 23:14:25', 'Edicion de acceso'),
(4, 1, 'M07', '2022-04-01 23:14:27', 'Edicion de acceso'),
(5, 1, 'M07', '2022-04-01 23:14:29', 'Edicion de acceso'),
(6, 1, 'M07', '2022-04-01 23:16:25', 'Creacion de acceso'),
(7, 1, 'M07', '2022-04-01 23:16:28', 'Creacion de acceso'),
(8, 1, 'M07', '2022-04-01 23:16:30', 'Creacion de acceso'),
(9, 1, 'M07', '2022-04-01 23:16:34', 'Creacion de acceso'),
(10, 1, 'M07', '2022-04-01 23:16:37', 'Creacion de acceso'),
(11, 1, 'M07', '2022-04-01 23:16:40', 'Creacion de acceso'),
(12, 1, 'M07', '2022-04-01 23:16:43', 'Creacion de acceso'),
(13, 1, 'M07', '2022-04-01 23:16:46', 'Creacion de acceso'),
(14, 1, 'M07', '2022-04-01 23:16:48', 'Creacion de acceso'),
(15, 1, 'M07', '2022-04-01 23:16:51', 'Creacion de acceso'),
(16, 1, 'M07', '2022-04-01 23:16:57', 'Edicion de acceso'),
(17, 1, 'M07', '2022-04-01 23:17:00', 'Edicion de acceso'),
(18, 1, 'M07', '2022-04-01 23:17:04', 'Edicion de acceso'),
(19, 1, 'M07', '2022-04-01 23:17:06', 'Edicion de acceso'),
(20, 1, 'M07', '2022-04-01 23:17:08', 'Edicion de acceso'),
(21, 1, 'M07', '2022-04-01 23:17:10', 'Edicion de acceso'),
(22, 1, 'M07', '2022-04-01 23:17:12', 'Edicion de acceso'),
(23, 1, 'M07', '2022-04-01 23:17:14', 'Edicion de acceso'),
(24, 1, 'M07', '2022-04-01 23:17:16', 'Edicion de acceso'),
(25, 1, 'M07', '2022-04-01 23:17:19', 'Edicion de acceso'),
(26, 1, 'M07', '2022-04-01 23:17:21', 'Edicion de acceso'),
(27, 1, 'M07', '2022-04-01 23:17:23', 'Edicion de acceso'),
(28, 1, 'M07', '2022-04-01 23:17:27', 'Edicion de acceso'),
(29, 1, 'M07', '2022-04-01 23:17:29', 'Edicion de acceso'),
(30, 1, 'M07', '2022-04-01 23:17:30', 'Edicion de acceso'),
(31, 1, 'M07', '2022-04-01 23:17:32', 'Edicion de acceso'),
(32, 1, 'M07', '2022-04-01 23:17:36', 'Edicion de acceso'),
(33, 1, 'M07', '2022-04-01 23:17:38', 'Edicion de acceso'),
(34, 1, 'M07', '2022-04-01 23:17:41', 'Edicion de acceso'),
(35, 1, 'M07', '2022-04-01 23:19:05', 'Edicion de acceso'),
(36, 1, 'M07', '2022-04-01 23:19:07', 'Edicion de acceso'),
(37, 1, 'M07', '2022-04-01 23:19:09', 'Edicion de acceso'),
(38, 1, 'M07', '2022-04-01 23:19:11', 'Edicion de acceso'),
(39, 1, 'M07', '2022-04-01 23:19:13', 'Edicion de acceso'),
(40, 1, 'M07', '2022-04-01 23:19:15', 'Edicion de acceso'),
(41, 1, 'M07', '2022-04-01 23:19:18', 'Edicion de acceso'),
(42, 1, 'M07', '2022-04-01 23:19:19', 'Edicion de acceso'),
(43, 1, 'M07', '2022-04-01 23:19:22', 'Edicion de acceso'),
(44, 1, 'M07', '2022-04-01 23:19:23', 'Edicion de acceso'),
(45, 1, 'M07', '2022-04-01 23:19:25', 'Edicion de acceso'),
(46, 1, 'M07', '2022-04-01 23:19:26', 'Edicion de acceso'),
(47, 1, 'M07', '2022-04-01 23:19:28', 'Edicion de acceso'),
(48, 1, 'M07', '2022-04-01 23:19:30', 'Edicion de acceso'),
(49, 1, 'M07', '2022-04-01 23:19:32', 'Edicion de acceso'),
(50, 1, 'M07', '2022-04-01 23:19:33', 'Edicion de acceso'),
(51, 1, 'M01', '2022-04-01 23:25:01', 'Creacion de medico'),
(52, 1, 'M01', '2022-04-02 11:08:49', 'Edicion de medico'),
(53, 1, 'M01', '2022-04-02 11:10:18', 'Creacion de medico'),
(54, 1, 'M01', '2022-04-02 11:11:28', 'Creacion de medico'),
(55, 1, 'M06', '2022-04-02 11:13:25', 'Creacion de departamento'),
(56, 1, 'M06', '2022-04-02 11:13:36', 'Edicion de departamento'),
(57, 1, 'M06', '2022-04-02 11:14:22', 'Creacion de departamento'),
(58, 1, 'M06', '2022-04-02 11:14:35', 'Creacion de departamento'),
(59, 1, 'M06', '2022-04-02 11:14:44', 'Creacion de departamento'),
(60, 1, 'M06', '2022-04-02 11:15:11', 'Creacion de departamento'),
(61, 1, 'M02', '2022-04-02 11:18:26', 'Creacion de enfermera'),
(62, 1, 'M02', '2022-04-02 11:24:47', 'Creacion de enfermera'),
(63, 1, 'M03', '2022-04-02 11:26:07', 'Creacion de paciente'),
(64, 1, 'M03', '2022-04-02 11:29:07', 'Creacion de paciente'),
(65, 1, 'M03', '2022-04-02 11:30:24', 'Creacion de paciente'),
(66, 1, 'M03', '2022-04-02 11:30:46', 'Edicion de paciente'),
(67, 1, 'M04', '2022-04-02 11:31:54', 'Creacion de usuario'),
(68, 1, 'M04', '2022-04-02 11:32:09', 'Edicion de usuario'),
(69, 1, 'M04', '2022-04-02 11:32:54', 'Creacion de usuario'),
(70, 1, 'M04', '2022-04-02 11:35:39', 'Edicion de usuario'),
(71, 1, 'M04', '2022-04-02 11:39:53', 'Edicion de usuario'),
(72, 1, 'M04', '2022-04-02 11:50:23', 'Edicion de usuario'),
(73, 1, 'M08', '2022-04-02 11:52:22', 'Creacion de especialidad'),
(74, 1, 'M08', '2022-04-02 11:52:29', 'Creacion de especialidad'),
(75, 1, 'M08', '2022-04-02 11:52:38', 'Creacion de especialidad'),
(76, 1, 'M08', '2022-04-02 11:52:46', 'Creacion de especialidad'),
(77, 1, 'M08', '2022-04-02 11:52:52', 'Creacion de especialidad'),
(78, 1, 'M08', '2022-04-02 11:53:13', 'Eliminacion de especialidad'),
(79, 1, 'M08', '2022-04-02 11:53:25', 'Creacion de especialidad'),
(80, 1, 'M05', '2022-04-02 11:54:12', 'Creacion de cita'),
(81, 1, 'M05', '2022-04-02 11:54:57', 'Creacion de cita'),
(82, 1, 'M05', '2022-04-02 11:58:35', 'Creacion de cita'),
(83, 1, 'M03', '2022-04-02 11:58:59', 'Edicion de paciente'),
(84, 1, 'M05', '2022-04-02 11:59:55', 'Edicion de cita'),
(85, 1, 'M09', '2022-04-02 12:00:55', 'Creacion de proveedor'),
(86, 1, 'M09', '2022-04-02 12:01:08', 'Deshabilitacion de proveedor'),
(87, 1, 'M09', '2022-04-02 12:01:14', 'Deshabilitacion de proveedor'),
(88, 1, 'M01', '2022-04-02 12:01:32', 'Deshabilitacion de medico'),
(89, 1, 'M01', '2022-04-02 12:01:35', 'Deshabilitacion de medico'),
(90, 1, 'M09', '2022-04-02 12:04:17', 'Deshabilitacion de proveedor'),
(91, 1, 'M09', '2022-04-02 12:04:24', 'Deshabilitacion de proveedor'),
(92, 1, 'M10', '2022-04-02 12:05:19', 'Creacion de medicamento'),
(93, 1, 'M10', '2022-04-02 12:06:32', 'Creacion de medicamento'),
(94, 1, 'M10', '2022-04-02 12:21:38', 'Creacion de medicamento'),
(95, 1, 'M11', '2022-04-02 12:23:41', 'Creacion de diagnostico'),
(96, 1, 'M11', '2022-04-02 12:25:47', 'Edicion de diagnostico'),
(97, 1, 'M10', '2022-04-02 12:27:45', 'Creacion de medicamento'),
(98, 1, 'M12', '2022-04-02 12:28:29', 'Creacion de receta'),
(99, 1, 'M12', '2022-04-02 12:28:34', 'Eliminacion de receta'),
(100, 1, 'M12', '2022-04-02 12:28:52', 'Creacion de receta'),
(101, 1, 'M07', '2022-04-02 12:29:56', 'Creacion de acceso'),
(102, 1, 'M07', '2022-04-02 12:29:59', 'Creacion de acceso'),
(103, 1, 'M07', '2022-04-02 12:30:57', 'Creacion de acceso'),
(104, 1, 'M07', '2022-04-02 12:31:00', 'Edicion de acceso'),
(105, 1, 'M07', '2022-04-02 12:31:03', 'Edicion de acceso'),
(106, 1, 'M07', '2022-04-02 12:31:05', 'Edicion de acceso'),
(107, 1, 'M07', '2022-04-02 12:31:07', 'Edicion de acceso'),
(108, 1, 'M07', '2022-04-02 12:31:09', 'Edicion de acceso'),
(109, 1, 'M07', '2022-04-02 12:31:11', 'Edicion de acceso'),
(110, 1, 'M07', '2022-04-02 12:31:12', 'Edicion de acceso'),
(111, 1, 'M07', '2022-04-02 12:31:14', 'Edicion de acceso'),
(112, 1, 'M07', '2022-04-02 12:31:16', 'Edicion de acceso'),
(113, 1, 'M07', '2022-04-02 12:31:18', 'Edicion de acceso'),
(114, 1, 'M07', '2022-04-02 12:31:20', 'Edicion de acceso'),
(115, 1, 'M04', '2022-04-02 20:45:55', 'Edicion de usuario'),
(116, 2, 'M05', '2022-04-02 20:48:12', 'Edicion de cita');

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE `cita` (
  `cod_cita` int(11) NOT NULL,
  `dni_paciente` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cod_departamento` int(11) NOT NULL,
  `dni_medico` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PENDIENTE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cita`
--

INSERT INTO `cita` (`cod_cita`, `dni_paciente`, `cod_departamento`, `dni_medico`, `fecha`, `estado`) VALUES
(1, '911111111', 1, '1111111111', '2022-04-02', 'ATENDIDA'),
(2, '911111111', 3, '22222222222', '2022-04-03', 'PENDIENTE'),
(3, '9333333', 5, '3333333333', '2022-04-02', 'PENDIENTE');

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `cod_departamento` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `ubicacion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`cod_departamento`, `nombre`, `precio`, `ubicacion`, `estado`) VALUES
(1, 'Psiquiatria', 450.00, 'psiquis', 'ACTIVO'),
(2, 'Psicologia', 200.00, 'psico', 'ACTIVO'),
(3, 'Cardiologia', 500.00, 'cardio', 'ACTIVO'),
(4, 'Neumologia', 450.00, 'neus', 'ACTIVO'),
(5, 'rinoplastia', 350.00, 'rino', 'ACTIVO');

-- --------------------------------------------------------

--
-- Table structure for table `diagnostico`
--

CREATE TABLE `diagnostico` (
  `cod_diagnostico` int(11) NOT NULL,
  `cod_cita` int(11) NOT NULL,
  `dni_medico` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dni_paciente` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `peso` int(11) DEFAULT NULL,
  `altura` int(11) DEFAULT NULL,
  `temperatura` int(11) DEFAULT NULL,
  `presion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sintomas` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `diagnostico`
--

INSERT INTO `diagnostico` (`cod_diagnostico`, `cod_cita`, `dni_medico`, `dni_paciente`, `fecha`, `peso`, `altura`, `temperatura`, `presion`, `sintomas`, `observaciones`, `precio`) VALUES
(1, 1, '1111111111', '911111111', '2022-04-02', 120, 150, 36, '60/70', 'mal de amores', 'no le para vola', 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `cod_empresa` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rtn` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`cod_empresa`, `nombre`, `rtn`, `telefono`, `email`, `direccion`) VALUES
(1, 'Clinica Vive', '156050195000865', '2476-9851', 'Atecion.cliente@vive.hn', 'Colonia la fantasia, Muni lugar, Depto hn');

-- --------------------------------------------------------

--
-- Table structure for table `enfermera`
--

CREATE TABLE `enfermera` (
  `dni_enfermera` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cod_usuario` int(11) DEFAULT NULL,
  `cod_departamento` int(11) DEFAULT NULL,
  `cod_turno` int(11) DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ingreso` date NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `enfermera`
--

INSERT INTO `enfermera` (`dni_enfermera`, `cod_usuario`, `cod_departamento`, `cod_turno`, `nombre`, `apellidos`, `sexo`, `telefono`, `celular`, `direccion`, `ingreso`, `estado`) VALUES
('12222222222', NULL, 4, 3, 'juan', 'del alba', 'M', '1234-1222', '1222-1222', 'rio', '2002-02-02', 'ACTIVO'),
('21111111111', 3, 1, 2, 'jorgina', 'reyes', 'F', '1234-2111', '2111-2111', 'jeorgia', '2001-01-01', 'ACTIVO');

-- --------------------------------------------------------

--
-- Table structure for table `especialidad`
--

CREATE TABLE `especialidad` (
  `cod_especialidad` int(11) NOT NULL,
  `dni_medico` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cod_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `especialidad`
--

INSERT INTO `especialidad` (`cod_especialidad`, `dni_medico`, `cod_departamento`) VALUES
(1, '1111111111', 1),
(2, '1111111111', 2),
(4, '22222222222', 4),
(5, '3333333333', 5),
(6, '22222222222', 3);

-- --------------------------------------------------------

--
-- Table structure for table `medicamento`
--

CREATE TABLE `medicamento` (
  `cod_medicamento` int(11) NOT NULL,
  `cod_proveedor` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ingreso` date NOT NULL,
  `vencimiento` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medicamento`
--

INSERT INTO `medicamento` (`cod_medicamento`, `cod_proveedor`, `nombre`, `ingreso`, `vencimiento`, `cantidad`, `costo`, `precio`, `descripcion`) VALUES
(1, 1, 'acetaminofen', '2001-01-01', '2050-01-01', 1200, 0.50, 5.00, 'para fiebre'),
(2, 1, 'bitaflenaco', '2002-01-01', '2050-02-02', 200, 10.00, 15.00, 'para el dolor y la tencion'),
(3, 1, 'gripex', '2003-01-01', '2030-01-01', 200, 2.00, 5.00, 'gripe mexicana'),
(4, 1, 'Pastilla de curar frijoles', '1900-01-01', '3000-01-01', 1000, 0.50, 1.00, 'para mal de amores');

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE `medico` (
  `dni_medico` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cod_usuario` int(11) DEFAULT NULL,
  `cod_turno` int(11) DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ingreso` date NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `medico`
--

INSERT INTO `medico` (`dni_medico`, `cod_usuario`, `cod_turno`, `nombre`, `apellidos`, `sexo`, `telefono`, `celular`, `direccion`, `ingreso`, `estado`) VALUES
('1111111111', 2, 2, 'juan', 'medrano', 'M', '1234-1111', '1111-1111', 'jamaica', '1982-01-01', 'ACTIVO'),
('22222222222', NULL, 4, 'fiona', 'florez', 'F', '1234-2222', '2222-2222', 'far far away', '1990-02-02', 'ACTIVO'),
('3333333333', NULL, 1, 'Dora', 'emon', 'F', '1234-3333', '3333-3333', 'algun sitio', '2000-03-03', 'ACTIVO');

-- --------------------------------------------------------

--
-- Table structure for table `modulo`
--

CREATE TABLE `modulo` (
  `cod_modulo` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modulo`
--

INSERT INTO `modulo` (`cod_modulo`, `nombre`, `descripcion`, `estado`) VALUES
('M01', 'Medicos', 'Modulo para la gestion de medicos', 'ACTIVO'),
('M02', 'Enfermeras', 'Modulo para la gestion de enfermeras', 'ACTIVO'),
('M03', 'Pacientes', 'Modulo para la gestion de pacientes', 'ACTIVO'),
('M04', 'Usuarios', 'Modulo para la gestion de usuarios', 'ACTIVO'),
('M05', 'Citas', 'Modulo para la gestion de citas', 'ACTIVO'),
('M06', 'Departamentos', 'Modulo para la gestion de departamentos', 'ACTIVO'),
('M07', 'Accesos', 'Modulo para la gestion de accesos', 'ACTIVO'),
('M08', 'Especialidades', 'Modulo para la gestion de especialidades', 'ACTIVO'),
('M09', 'Proveedores', 'Modulo para la gestion de proveedores', 'ACTIVO'),
('M10', 'Medicamentos', 'Modulo para la gestion de medicamentos', 'ACTIVO'),
('M11', 'Diagnosticos', 'Modulo para la gestion de diagnosticos', 'ACTIVO'),
('M12', 'Recetas', 'Modulo para la gestion de recetas', 'ACTIVO'),
('M13', 'Bitacora', '', 'ACTIVO');

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `dni_paciente` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `sexo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `historial` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`dni_paciente`, `nombre`, `apellidos`, `nacimiento`, `sexo`, `telefono`, `celular`, `direccion`, `historial`, `ingreso`) VALUES
('911111111', 'pedrin', 'flores', '2001-01-01', 'M', '9111-1111', '9111-1111', 'sps', 'cancer', '2009-01-01'),
('92222222', 'sharon', 'rodriguez', '2005-01-02', 'F', '9222-9222', '9222-9222', 'copan', 'alergia', '2015-02-02'),
('9333333', 'raul', 'solorsano', '2000-03-03', 'M', '9333-9333', '9233-9333', 'gracias', 'solo sano', '2018-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `cod_proveedor` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pais` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`cod_proveedor`, `nombre`, `tipo`, `email`, `telefono`, `pais`, `observaciones`, `estado`) VALUES
(1, 'vic', 'medicina', 'vic@mail.com', '8-654-65161', 'usa', 'dr. vic', 'ACTIVO');

-- --------------------------------------------------------

--
-- Table structure for table `receta`
--

CREATE TABLE `receta` (
  `cod_receta` int(11) NOT NULL,
  `cod_diagnostico` int(11) NOT NULL,
  `cod_medicamento` int(11) NOT NULL,
  `dosis` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `receta`
--

INSERT INTO `receta` (`cod_receta`, `cod_diagnostico`, `cod_medicamento`, `dosis`, `periodo`) VALUES
(2, 1, 4, '2 al dia', 'durante una semana');

-- --------------------------------------------------------

--
-- Table structure for table `recibo_cita`
--

CREATE TABLE `recibo_cita` (
  `cod_recibo_cita` int(11) NOT NULL,
  `cod_cita` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recibo_diagnostico`
--

CREATE TABLE `recibo_diagnostico` (
  `cod_recibo_diagnostico` int(11) NOT NULL,
  `cod_diagnostico` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `cod_turno` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `turno`
--

INSERT INTO `turno` (`cod_turno`, `nombre`, `descripcion`) VALUES
(1, 'Flexible', 'Se trabaja cuando es requerido solamente'),
(2, 'Dia', 'Desde las 06:00am hasta las 02:00pm'),
(3, 'Tarde', 'Desde las 02:00pm hasta las 10:00pm'),
(4, 'Noche', 'Desde las 10:00pm hasta las 06:00am');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `cod_usuario` int(11) NOT NULL,
  `usuario` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ACTIVO',
  `creador` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `usuario`, `clave`, `tipo`, `estado`, `creador`, `fecha`) VALUES
(1, 'admin', 'admin', 'ADMINISTRADOR', 'ACTIVO', 1, '2000-01-01 00:00:00'),
(2, 'juachi', '123456789', 'MEDICO', 'ACTIVO', 1, '2022-04-02 11:31:54'),
(3, 'jreyna', '#96688', 'ENFERMERA', 'ACTIVO', 1, '2022-04-02 11:32:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`cod_acceso`),
  ADD KEY `cod_modulo` (`cod_modulo`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`cod_bitacora`),
  ADD KEY `cod_modulo` (`cod_modulo`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`cod_cita`),
  ADD KEY `dni_paciente` (`dni_paciente`),
  ADD KEY `cod_departamento` (`cod_departamento`),
  ADD KEY `dni_medico` (`dni_medico`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`cod_departamento`);

--
-- Indexes for table `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD PRIMARY KEY (`cod_diagnostico`),
  ADD KEY `cod_cita` (`cod_cita`),
  ADD KEY `dni_paciente` (`dni_paciente`),
  ADD KEY `dni_medico` (`dni_medico`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`cod_empresa`);

--
-- Indexes for table `enfermera`
--
ALTER TABLE `enfermera`
  ADD PRIMARY KEY (`dni_enfermera`),
  ADD UNIQUE KEY `cod_usuario` (`cod_usuario`),
  ADD KEY `cod_departamento` (`cod_departamento`),
  ADD KEY `cod_turno` (`cod_turno`);

--
-- Indexes for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`cod_especialidad`),
  ADD KEY `dni_medico` (`dni_medico`),
  ADD KEY `cod_departamento` (`cod_departamento`);

--
-- Indexes for table `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`cod_medicamento`),
  ADD KEY `cod_proveedor` (`cod_proveedor`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`dni_medico`),
  ADD UNIQUE KEY `cod_usuario` (`cod_usuario`),
  ADD KEY `cod_turno` (`cod_turno`);

--
-- Indexes for table `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`cod_modulo`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`dni_paciente`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`cod_proveedor`);

--
-- Indexes for table `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`cod_receta`),
  ADD KEY `cod_diagnostico` (`cod_diagnostico`),
  ADD KEY `cod_medicamento` (`cod_medicamento`);

--
-- Indexes for table `recibo_cita`
--
ALTER TABLE `recibo_cita`
  ADD PRIMARY KEY (`cod_recibo_cita`),
  ADD KEY `cod_cita` (`cod_cita`);

--
-- Indexes for table `recibo_diagnostico`
--
ALTER TABLE `recibo_diagnostico`
  ADD PRIMARY KEY (`cod_recibo_diagnostico`),
  ADD KEY `cod_diagnostico` (`cod_diagnostico`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`cod_turno`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `creador` (`creador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acceso`
--
ALTER TABLE `acceso`
  MODIFY `cod_acceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `cod_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `cita`
--
ALTER TABLE `cita`
  MODIFY `cod_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `cod_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `diagnostico`
--
ALTER TABLE `diagnostico`
  MODIFY `cod_diagnostico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `cod_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `cod_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `cod_medicamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `cod_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receta`
--
ALTER TABLE `receta`
  MODIFY `cod_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recibo_cita`
--
ALTER TABLE `recibo_cita`
  MODIFY `cod_recibo_cita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recibo_diagnostico`
--
ALTER TABLE `recibo_diagnostico`
  MODIFY `cod_recibo_diagnostico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `cod_turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acceso`
--
ALTER TABLE `acceso`
  ADD CONSTRAINT `acceso_ibfk_1` FOREIGN KEY (`cod_modulo`) REFERENCES `modulo` (`cod_modulo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `acceso_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`cod_modulo`) REFERENCES `modulo` (`cod_modulo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bitacora_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`dni_paciente`) REFERENCES `paciente` (`dni_paciente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`cod_departamento`) REFERENCES `departamento` (`cod_departamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`dni_medico`) REFERENCES `medico` (`dni_medico`) ON UPDATE CASCADE;

--
-- Constraints for table `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD CONSTRAINT `diagnostico_ibfk_1` FOREIGN KEY (`cod_cita`) REFERENCES `cita` (`cod_cita`) ON UPDATE CASCADE,
  ADD CONSTRAINT `diagnostico_ibfk_2` FOREIGN KEY (`dni_paciente`) REFERENCES `paciente` (`dni_paciente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `diagnostico_ibfk_3` FOREIGN KEY (`dni_medico`) REFERENCES `medico` (`dni_medico`) ON UPDATE CASCADE;

--
-- Constraints for table `enfermera`
--
ALTER TABLE `enfermera`
  ADD CONSTRAINT `enfermera_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `enfermera_ibfk_2` FOREIGN KEY (`cod_departamento`) REFERENCES `departamento` (`cod_departamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `enfermera_ibfk_3` FOREIGN KEY (`cod_turno`) REFERENCES `turno` (`cod_turno`) ON UPDATE CASCADE;

--
-- Constraints for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD CONSTRAINT `especialidad_ibfk_1` FOREIGN KEY (`dni_medico`) REFERENCES `medico` (`dni_medico`) ON UPDATE CASCADE,
  ADD CONSTRAINT `especialidad_ibfk_2` FOREIGN KEY (`cod_departamento`) REFERENCES `departamento` (`cod_departamento`) ON UPDATE CASCADE;

--
-- Constraints for table `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`cod_proveedor`) ON UPDATE CASCADE;

--
-- Constraints for table `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `medico_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `medico_ibfk_2` FOREIGN KEY (`cod_turno`) REFERENCES `turno` (`cod_turno`) ON UPDATE CASCADE;

--
-- Constraints for table `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`cod_diagnostico`) REFERENCES `diagnostico` (`cod_diagnostico`) ON UPDATE CASCADE,
  ADD CONSTRAINT `receta_ibfk_2` FOREIGN KEY (`cod_medicamento`) REFERENCES `medicamento` (`cod_medicamento`) ON UPDATE CASCADE;

--
-- Constraints for table `recibo_cita`
--
ALTER TABLE `recibo_cita`
  ADD CONSTRAINT `recibo_cita_ibfk_1` FOREIGN KEY (`cod_cita`) REFERENCES `cita` (`cod_cita`) ON UPDATE CASCADE;

--
-- Constraints for table `recibo_diagnostico`
--
ALTER TABLE `recibo_diagnostico`
  ADD CONSTRAINT `recibo_diagnostico_ibfk_1` FOREIGN KEY (`cod_diagnostico`) REFERENCES `diagnostico` (`cod_diagnostico`) ON UPDATE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`creador`) REFERENCES `usuario` (`cod_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
