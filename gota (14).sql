-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2023 a las 21:24:15
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gota`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apertura_cobrador`
--

CREATE TABLE `apertura_cobrador` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_apertura` date NOT NULL,
  `hora_apertura` time NOT NULL,
  `fecha_y_hora_apertura` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE `calendario` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `dia` varchar(20) NOT NULL,
  `cobrable` int(11) NOT NULL COMMENT '0=No se cobra \r\n1= Cobrable '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calendario`
--

INSERT INTO `calendario` (`id`, `fecha`, `dia`, `cobrable`) VALUES
(1, '2023-08-21', 'Lunes', 1),
(2, '2023-08-22', 'Martes', 1),
(3, '2023-08-23', 'Miercoles', 1),
(4, '2023-08-24', 'Jueves', 1),
(5, '2023-08-25', 'Viernes', 1),
(6, '2023-08-26', 'Sabado', 1),
(7, '2023-08-27', 'Domingo', 0),
(8, '2023-08-28', 'Lunes', 1),
(9, '2023-08-29', 'Martes', 1),
(10, '2023-08-30', 'Miercoles', 1),
(11, '2023-08-31', 'Jueves', 1),
(12, '2023-09-01', 'Viernes', 1),
(13, '2023-09-02', 'Sabado', 1),
(14, '2023-09-03', 'Domingo', 0),
(15, '2023-09-04', 'Lunes', 1),
(16, '2023-09-05', 'Martes', 1),
(17, '2023-09-06', 'Miercoles', 1),
(18, '2023-09-07', 'Jueves', 1),
(19, '2023-09-08', 'Viernes', 1),
(20, '2023-09-09', 'Sabado', 1),
(21, '2023-09-10', 'Domingo', 0),
(22, '2023-09-11', 'Lunes', 1),
(23, '2023-09-12', 'Martes', 1),
(24, '2023-09-13', 'Miercoles', 1),
(25, '2023-09-14', 'Jueves', 1),
(26, '2023-09-15', 'Viernes', 1),
(27, '2023-09-16', 'Sabado', 1),
(28, '2023-09-17', 'Domingo', 0),
(29, '2023-09-18', 'Lunes', 1),
(30, '2023-09-19', 'Martes', 1),
(31, '2023-09-20', 'Miercoles', 1),
(32, '2023-09-21', 'Jueves', 1),
(33, '2023-09-22', 'Viernes', 1),
(34, '2023-09-23', 'Sabado', 1),
(35, '2023-09-24', 'Domingo', 0),
(36, '2023-09-25', 'Lunes', 1),
(37, '2023-09-26', 'Martes', 1),
(38, '2023-09-27', 'Miercoles', 1),
(39, '2023-09-28', 'Jueves', 1),
(40, '2023-09-29', 'Viernes', 0),
(41, '2023-09-30', 'Sabado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `id_tercero` int(11) NOT NULL,
  `telefono_de_contacto` varchar(30) NOT NULL,
  `referencia_personal` varchar(30) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_usuario` int(11) NOT NULL,
  `direccion_negocio` varchar(100) NOT NULL,
  `telefono_negocio` varchar(30) NOT NULL,
  `imagen_dni` varchar(100) NOT NULL,
  `imagen_cliente` varchar(100) NOT NULL,
  `imagen_casa` varchar(100) NOT NULL,
  `imagen_negocio` varchar(100) NOT NULL,
  `imagen_servicio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `id_tercero`, `telefono_de_contacto`, `referencia_personal`, `estado`, `id_usuario`, `direccion_negocio`, `telefono_negocio`, `imagen_dni`, `imagen_cliente`, `imagen_casa`, `imagen_negocio`, `imagen_servicio`) VALUES
(43, 1, '3133905693', 'd', 1, 8, 'San clemente', '3146797136', '1.png', '1.png', '1.png', '1.png', '1.png'),
(49, 42, '3122149788', 'lucy ', 1, 8, 'Carrera 3 # 5 53 San Clemente ', '3122149788', '42.png', '', '', '42.png', '42.png'),
(50, 44, 'DASd', 'asdd', 1, 8, 'XASD', 'asdD', '', '', '', '', ''),
(51, 45, 'rwqer', 'werqw', 1, 8, 'rewqr', 'wer', '', '', '', '', ''),
(52, 46, 'Bb', 'Bbbbj', 1, 8, 'Bbb', 'Bbb', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_x_c`
--

CREATE TABLE `c_x_c` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero_cuotas` int(11) NOT NULL,
  `valor_prestamo` float NOT NULL,
  `valor_cuota` float NOT NULL,
  `cuotas_atrasadas` int(11) NOT NULL DEFAULT 0,
  `cuotas_al_dia` int(11) NOT NULL DEFAULT 0,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `fecha_creacion` date NOT NULL,
  `dias_atraso` int(11) NOT NULL DEFAULT 0,
  `saldo_prestamo` float NOT NULL,
  `tipo_prestamo` int(11) NOT NULL COMMENT '1=Nuevo \r\n2=Renovacion',
  `frecuencia` varchar(50) NOT NULL,
  `cuotas_pendientes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `c_x_c`
--

INSERT INTO `c_x_c` (`id`, `id_cliente`, `id_ruta`, `id_usuario`, `numero_cuotas`, `valor_prestamo`, `valor_cuota`, `cuotas_atrasadas`, `cuotas_al_dia`, `fecha_inicio`, `fecha_final`, `fecha_creacion`, `dias_atraso`, `saldo_prestamo`, `tipo_prestamo`, `frecuencia`, `cuotas_pendientes`) VALUES
(1, 43, 1, 8, 20, 200000, 12000, 0, 0, '2023-08-23', '2023-09-30', '2023-08-22', 32, 240000, 1, '1', 20),
(2, 43, 1, 8, 20, 200000, 12000, 0, 0, '2023-08-23', '2023-09-30', '2023-08-22', 32, 240000, 1, '1', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencia_pago`
--

CREATE TABLE `frecuencia_pago` (
  `id` int(11) NOT NULL,
  `frecuencia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `frecuencia_pago`
--

INSERT INTO `frecuencia_pago` (`id`, `frecuencia`) VALUES
(1, 'Diario '),
(2, 'Semanal '),
(3, 'Quincenal'),
(4, 'Mensual ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `fecha` int(11) NOT NULL,
  `hora` int(11) NOT NULL,
  `fecha_y_hora` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_apertura` int(11) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos_adicionales`
--

CREATE TABLE `ingresos_adicionales` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `valor` double NOT NULL,
  `Concepto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingresos_adicionales`
--

INSERT INTO `ingresos_adicionales` (`id`, `fecha`, `id_usuario`, `valor`, `Concepto`) VALUES
(1, '2023-08-08', 8, 500000, 'PRUEBA'),
(2, '2023-08-08', 8, 444, 'fff'),
(3, '2023-08-08', 8, 1000000, 'PRUEBA 2 '),
(4, '2023-08-08', 8, 2000, 'Pruebas '),
(5, '2023-08-23', 8, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_pagos`
--

CREATE TABLE `plan_pagos` (
  `id` int(11) NOT NULL,
  `id_cxc` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_pago` date NOT NULL,
  `hora_pago` time NOT NULL,
  `valor_cuota` float NOT NULL,
  `dias_atraso` int(11) NOT NULL DEFAULT 0,
  `estado` int(1) NOT NULL DEFAULT 1,
  `fecha_y_hora_pago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numero_cuota` int(11) NOT NULL,
  `saldo_cuota` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `plan_pagos`
--

INSERT INTO `plan_pagos` (`id`, `id_cxc`, `id_cliente`, `id_usuario`, `id_ruta`, `fecha_vencimiento`, `fecha_pago`, `hora_pago`, `valor_cuota`, `dias_atraso`, `estado`, `fecha_y_hora_pago`, `numero_cuota`, `saldo_cuota`) VALUES
(1, 1, 43, 8, 1, '2023-08-23', '0000-00-00', '00:00:00', 12000, 32, 1, '2023-10-03 13:04:27', 1, 12000),
(2, 1, 43, 8, 1, '2023-08-24', '0000-00-00', '00:00:00', 12000, 31, 1, '2023-10-03 13:04:27', 2, 12000),
(3, 1, 43, 8, 1, '2023-08-25', '0000-00-00', '00:00:00', 12000, 30, 1, '2023-10-03 13:04:27', 3, 12000),
(4, 1, 43, 8, 1, '2023-08-26', '0000-00-00', '00:00:00', 12000, 29, 1, '2023-10-03 13:04:27', 4, 12000),
(5, 1, 43, 8, 1, '2023-08-28', '0000-00-00', '00:00:00', 12000, 28, 1, '2023-10-03 13:04:27', 5, 12000),
(6, 1, 43, 8, 1, '2023-08-29', '0000-00-00', '00:00:00', 12000, 27, 1, '2023-10-03 13:04:27', 6, 12000),
(7, 1, 43, 8, 1, '2023-08-30', '0000-00-00', '00:00:00', 12000, 26, 1, '2023-10-03 13:04:27', 7, 12000),
(8, 1, 43, 8, 1, '2023-08-31', '0000-00-00', '00:00:00', 12000, 25, 1, '2023-10-03 13:04:27', 8, 12000),
(9, 1, 43, 8, 1, '2023-09-01', '0000-00-00', '00:00:00', 12000, 24, 1, '2023-10-03 13:04:27', 9, 12000),
(10, 1, 43, 8, 1, '2023-09-02', '0000-00-00', '00:00:00', 12000, 23, 1, '2023-10-03 13:04:27', 10, 12000),
(11, 1, 43, 8, 1, '2023-09-04', '0000-00-00', '00:00:00', 12000, 22, 1, '2023-10-03 13:04:27', 11, 12000),
(12, 1, 43, 8, 1, '2023-09-05', '0000-00-00', '00:00:00', 12000, 21, 1, '2023-10-03 13:04:27', 12, 12000),
(13, 1, 43, 8, 1, '2023-09-06', '0000-00-00', '00:00:00', 12000, 20, 1, '2023-10-03 13:04:27', 13, 12000),
(14, 1, 43, 8, 1, '2023-09-07', '0000-00-00', '00:00:00', 12000, 19, 1, '2023-10-03 13:04:27', 14, 12000),
(15, 1, 43, 8, 1, '2023-09-08', '0000-00-00', '00:00:00', 12000, 18, 1, '2023-10-03 13:04:27', 15, 12000),
(16, 1, 43, 8, 1, '2023-09-09', '0000-00-00', '00:00:00', 12000, 17, 1, '2023-10-03 13:04:27', 16, 12000),
(17, 1, 43, 8, 1, '2023-09-11', '0000-00-00', '00:00:00', 12000, 16, 1, '2023-10-03 13:04:27', 17, 12000),
(18, 1, 43, 8, 1, '2023-09-12', '0000-00-00', '00:00:00', 12000, 15, 1, '2023-10-03 13:04:27', 18, 12000),
(19, 1, 43, 8, 1, '2023-09-13', '0000-00-00', '00:00:00', 12000, 14, 1, '2023-10-03 13:04:27', 19, 12000),
(20, 1, 43, 8, 1, '2023-09-14', '0000-00-00', '00:00:00', 12000, 13, 1, '2023-10-03 13:04:27', 20, 12000),
(21, 2, 43, 8, 1, '2023-08-23', '0000-00-00', '00:00:00', 12000, 32, 1, '2023-10-03 13:04:27', 1, 12000),
(22, 2, 43, 8, 1, '2023-08-24', '0000-00-00', '00:00:00', 12000, 31, 1, '2023-10-03 13:04:27', 2, 12000),
(23, 2, 43, 8, 1, '2023-08-25', '0000-00-00', '00:00:00', 12000, 30, 1, '2023-10-03 13:04:27', 3, 12000),
(24, 2, 43, 8, 1, '2023-08-26', '0000-00-00', '00:00:00', 12000, 29, 1, '2023-10-03 13:04:27', 4, 12000),
(25, 2, 43, 8, 1, '2023-08-28', '0000-00-00', '00:00:00', 12000, 28, 1, '2023-10-03 13:04:27', 5, 12000),
(26, 2, 43, 8, 1, '2023-08-29', '0000-00-00', '00:00:00', 12000, 27, 1, '2023-10-03 13:04:27', 6, 12000),
(27, 2, 43, 8, 1, '2023-08-30', '0000-00-00', '00:00:00', 12000, 26, 1, '2023-10-03 13:04:27', 7, 12000),
(28, 2, 43, 8, 1, '2023-08-31', '0000-00-00', '00:00:00', 12000, 25, 1, '2023-10-03 13:04:27', 8, 12000),
(29, 2, 43, 8, 1, '2023-09-01', '0000-00-00', '00:00:00', 12000, 24, 1, '2023-10-03 13:04:27', 9, 12000),
(30, 2, 43, 8, 1, '2023-09-02', '0000-00-00', '00:00:00', 12000, 23, 1, '2023-10-03 13:04:27', 10, 12000),
(31, 2, 43, 8, 1, '2023-09-04', '0000-00-00', '00:00:00', 12000, 22, 1, '2023-10-03 13:04:27', 11, 12000),
(32, 2, 43, 8, 1, '2023-09-05', '0000-00-00', '00:00:00', 12000, 21, 1, '2023-10-03 13:04:27', 12, 12000),
(33, 2, 43, 8, 1, '2023-09-06', '0000-00-00', '00:00:00', 12000, 20, 1, '2023-10-03 13:04:27', 13, 12000),
(34, 2, 43, 8, 1, '2023-09-07', '0000-00-00', '00:00:00', 12000, 19, 1, '2023-10-03 13:04:27', 14, 12000),
(35, 2, 43, 8, 1, '2023-09-08', '0000-00-00', '00:00:00', 12000, 18, 1, '2023-10-03 13:04:27', 15, 12000),
(36, 2, 43, 8, 1, '2023-09-09', '0000-00-00', '00:00:00', 12000, 17, 1, '2023-10-03 13:04:27', 16, 12000),
(37, 2, 43, 8, 1, '2023-09-11', '0000-00-00', '00:00:00', 12000, 16, 1, '2023-10-03 13:04:27', 17, 12000),
(38, 2, 43, 8, 1, '2023-09-12', '0000-00-00', '00:00:00', 12000, 15, 1, '2023-10-03 13:04:27', 18, 12000),
(39, 2, 43, 8, 1, '2023-09-13', '0000-00-00', '00:00:00', 12000, 14, 1, '2023-10-03 13:04:27', 19, 12000),
(40, 2, 43, 8, 1, '2023-09-14', '0000-00-00', '00:00:00', 12000, 13, 1, '2023-10-03 13:04:27', 20, 12000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Cobrador'),
(4, 'Contabilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cuentas_activas` int(11) NOT NULL,
  `cuentas_atrasadas` int(11) NOT NULL,
  `cuentas_al_dia` int(11) NOT NULL,
  `cartera_atrasada` int(11) NOT NULL,
  `debido_cobrar` float NOT NULL,
  `valor_ruta` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`id`, `nombre`, `cuentas_activas`, `cuentas_atrasadas`, `cuentas_al_dia`, `cartera_atrasada`, `debido_cobrar`, `valor_ruta`) VALUES
(1, 'LIMA', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas_usuarios`
--

CREATE TABLE `rutas_usuarios` (
  `id` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terceros`
--

CREATE TABLE `terceros` (
  `id` int(11) NOT NULL,
  `tipo_identificacion` int(11) NOT NULL,
  `numero_identificacion` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '0=inactivo \r\n1=activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `terceros`
--

INSERT INTO `terceros` (`id`, `tipo_identificacion`, `numero_identificacion`, `nombres`, `direccion`, `telefono`, `email`, `estado`) VALUES
(1, 1, '9697642', 'CRISTIAN CAMILO HOYOS RAMIREZ', 'Carrera 3 # 5- 52 san clemete', '3133905693', 'contoso@gmail.com', 1),
(42, 1, '1088001723', 'Yeison Federico Hoyos Ramirez', 'Carrera 3 # 5 53 San Clemente ', '3122149788', 'ejemplo@gmail.com', 1),
(43, 1, '123456', 'Ruber ', 'Peru ', 'xxxx', '', 1),
(44, 1, '234123', 'sdEW', 'Carrera 15, Santa Rosa de Cabal, Risaralda, RAP Ej', 'DASd', 'ASd', 1),
(45, 1, '41324', 'ewrqr', 'Carrera 3, San Clemente, Guática, Vertiente Occide', 'rwqer', 'ewr', 1),
(46, 1, '1235', 'Vh', 'Bjj', 'Bb', 'Jjj', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_identificacion`
--

CREATE TABLE `tipos_identificacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_identificacion`
--

INSERT INTO `tipos_identificacion` (`id`, `nombre`) VALUES
(1, 'Cédula de ciudadanía '),
(2, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `id_tercero` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '0=Inactivo \r\n1=Activo',
  `id_ruta` int(11) NOT NULL,
  `numero_de_accesos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `id_tercero`, `usuario`, `password`, `id_rol`, `estado`, `id_ruta`, `numero_de_accesos`) VALUES
(8, 1, 'cristian.hoyos', '$2y$10$0k6x/G2NPS.WHr9IsTyHCeOPCV7ycHkx4DfNP.nyTjqR5b0ms9dP6', 1, 1, 1, 44),
(45, 43, 'ruber.ruber', '$2y$10$m4kCll6GtMEujJvkilWtVej4LL1DNoKEjHtz4wR46ddqVKciMwRju', 1, 1, 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_terceros` (`id_tercero`),
  ADD KEY `ID_usuari` (`id_usuario`);

--
-- Indices de la tabla `c_x_c`
--
ALTER TABLE `c_x_c`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_clientes` (`id_cliente`),
  ADD KEY `ID_rutas` (`id_ruta`),
  ADD KEY `ID_user` (`id_usuario`);

--
-- Indices de la tabla `frecuencia_pago`
--
ALTER TABLE `frecuencia_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos_adicionales`
--
ALTER TABLE `ingresos_adicionales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plan_pagos`
--
ALTER TABLE `plan_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_c_x_c` (`id_cxc`),
  ADD KEY `ID_cliente` (`id_cliente`),
  ADD KEY `ID_usuario` (`id_usuario`),
  ADD KEY `ID_ruta` (`id_ruta`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutas_usuarios`
--
ALTER TABLE `rutas_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `terceros`
--
ALTER TABLE `terceros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_tipo_identificacacion` (`tipo_identificacion`);

--
-- Indices de la tabla `tipos_identificacion`
--
ALTER TABLE `tipos_identificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tercero` (`id_tercero`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `ID_route` (`id_ruta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `c_x_c`
--
ALTER TABLE `c_x_c`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `frecuencia_pago`
--
ALTER TABLE `frecuencia_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingresos_adicionales`
--
ALTER TABLE `ingresos_adicionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `plan_pagos`
--
ALTER TABLE `plan_pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rutas_usuarios`
--
ALTER TABLE `rutas_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `terceros`
--
ALTER TABLE `terceros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `tipos_identificacion`
--
ALTER TABLE `tipos_identificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `ID_terceros` FOREIGN KEY (`id_tercero`) REFERENCES `terceros` (`id`),
  ADD CONSTRAINT `ID_usuari` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `c_x_c`
--
ALTER TABLE `c_x_c`
  ADD CONSTRAINT `ID_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `ID_rutas` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id`),
  ADD CONSTRAINT `ID_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `plan_pagos`
--
ALTER TABLE `plan_pagos`
  ADD CONSTRAINT `ID_c_x_c` FOREIGN KEY (`id_cxc`) REFERENCES `c_x_c` (`id`),
  ADD CONSTRAINT `ID_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `ID_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id`),
  ADD CONSTRAINT `ID_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `terceros`
--
ALTER TABLE `terceros`
  ADD CONSTRAINT `ID_tipo_identificacacion` FOREIGN KEY (`tipo_identificacion`) REFERENCES `tipos_identificacion` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `ID_route` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id`),
  ADD CONSTRAINT `id_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `id_tercero` FOREIGN KEY (`id_tercero`) REFERENCES `terceros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
