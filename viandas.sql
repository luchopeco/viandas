-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-10-2015 a las 20:10:35
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `viandas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimento`
--

CREATE TABLE IF NOT EXISTS `alimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `tipo_alimento_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alimento_tipo_alimento1_idx` (`tipo_alimento_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `alimento`
--

INSERT INTO `alimento` (`id`, `nombre`, `descripcion`, `estado`, `tipo_alimento_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Carne', 'Carne Vacuna', 'Activo', 3, NULL, NULL, NULL),
(2, 'Zanahoria', 'znahoria', 'ok', 3, '2015-10-15 08:13:55', '2015-10-15 08:13:55', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `dni` int(11) DEFAULT NULL,
  `domicilio` varchar(45) DEFAULT NULL,
  `telefono` varchar(255) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `estado_deuda` varchar(45) DEFAULT NULL,
  `valor_deuda` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apellido`, `dni`, `domicilio`, `telefono`, `email`, `estado_deuda`, `valor_deuda`, `estado`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 'Pepe', 'Argento', 35796548, 'San martin 1540', '341-654', 'asdasd@asd.com', 'Deudor', NULL, NULL, '2015-10-19 14:58:33', '2015-10-19 14:58:33', '2015-10-19 14:58:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_dia`
--

CREATE TABLE IF NOT EXISTS `cliente_dia` (
  `cliente_id` int(11) NOT NULL,
  `dia_semana_id` int(11) NOT NULL,
  `tipo_vianda_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`,`dia_semana_id`),
  KEY `fk_cliente_has_dia_semana_dia_semana1_idx` (`dia_semana_id`),
  KEY `fk_cliente_has_dia_semana_cliente1_idx` (`cliente_id`),
  KEY `fk_cliente_has_dia_semana_tipo_vianda1_idx` (`tipo_vianda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_dias`
--

CREATE TABLE IF NOT EXISTS `cliente_dias` (
  `idcliente_dias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dia_semana`
--

CREATE TABLE IF NOT EXISTS `dia_semana` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE IF NOT EXISTS `envios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zona` varchar(45) DEFAULT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `observaciones` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `no_laborables`
--

CREATE TABLE IF NOT EXISTS `no_laborables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `motivo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `no_laborables`
--

INSERT INTO `no_laborables` (`id`, `fecha`, `motivo`, `estado`, `created_at`, `updated_at`) VALUES
(2, '2014-11-24', 'alguno', NULL, '2015-10-15 03:51:25', '2015-10-15 03:51:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `no_me_gusta`
--

CREATE TABLE IF NOT EXISTS `no_me_gusta` (
  `cliente_id` int(11) NOT NULL,
  `alimento_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  KEY `fk_no_me_gusta_cliente_idx` (`cliente_id`),
  KEY `fk_no_me_gusta_alimento1_idx` (`alimento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `envio` varchar(45) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `tipo_vianda_id` int(11) NOT NULL,
  `fecha_pedido` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedido_cliente1_idx` (`cliente_id`),
  KEY `fk_pedido_tipo_vianda1_idx` (`tipo_vianda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_alimento`
--

CREATE TABLE IF NOT EXISTS `tipo_alimento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_alimento`
--

INSERT INTO `tipo_alimento` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Mas Dietetico', 'asd', '2015-10-08 20:29:50', '2015-10-08 20:29:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_vianda`
--

CREATE TABLE IF NOT EXISTS `tipo_vianda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo_vianda`
--

INSERT INTO `tipo_vianda` (`id`, `nombre`, `descripcion`, `precio`, `created_at`, `updated_at`) VALUES
(1, 'light', 'light sss', '33', '2015-10-13 00:50:37', '2015-10-13 00:51:15'),
(2, 'natural', 'natural', '43', '2015-10-13 00:51:35', '2015-10-13 00:51:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'admin', '$2y$10$guP8JGpR8xVTWR0LVww2OuLlcjPNogPnOXwrwPmXxAF/krhM8hSm2', NULL, NULL, '2015-10-15 08:14:54', 'YGuVBbKr7rmiBduRADHd4cVdlabPIFMWCfRhKeqd0qYtsNf2olhnpFTBwg2f');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alimento`
--
ALTER TABLE `alimento`
  ADD CONSTRAINT `fk_alimento_tipo_alimento1` FOREIGN KEY (`tipo_alimento_id`) REFERENCES `tipo_alimento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente_dia`
--
ALTER TABLE `cliente_dia`
  ADD CONSTRAINT `fk_cliente_has_dia_semana_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_dia_semana_dia_semana1` FOREIGN KEY (`dia_semana_id`) REFERENCES `dia_semana` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_dia_semana_tipo_vianda1` FOREIGN KEY (`tipo_vianda_id`) REFERENCES `tipo_vianda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `no_me_gusta`
--
ALTER TABLE `no_me_gusta`
  ADD CONSTRAINT `fk_no_me_gusta_alimento1` FOREIGN KEY (`alimento_id`) REFERENCES `alimento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_no_me_gusta_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_tipo_vianda1` FOREIGN KEY (`tipo_vianda_id`) REFERENCES `tipo_vianda` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
