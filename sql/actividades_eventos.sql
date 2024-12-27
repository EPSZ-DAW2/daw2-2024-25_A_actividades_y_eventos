-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-12-2024 a las 19:35:06
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `actividades_eventos`
--
CREATE DATABASE IF NOT EXISTS `actividades_eventos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `actividades_eventos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_celebracion` date DEFAULT NULL,
  `duracion_estimada` varchar(500) DEFAULT NULL,
  `lugar_celebracion` varchar(500) DEFAULT NULL,
  `detalles` text DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `imagen_principal` blob DEFAULT NULL,
  `edad_recomendada` varchar(500) DEFAULT NULL,
  `etiquetas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`etiquetas`)),
  `estado_actividad` varchar(500) DEFAULT NULL,
  `patrocinios_actividad` bigint(20) DEFAULT NULL,
  `seguimientos` int(11) DEFAULT NULL,
  `participacion` int(11) DEFAULT NULL,
  `valoracion` float DEFAULT NULL,
  `comentarios` bigint(20) DEFAULT NULL,
  `clasificacion` bigint(20) DEFAULT NULL,
  `imagenes_adicionales` bigint(20) DEFAULT NULL,
  `votosOK` int(11) DEFAULT NULL,
  `votosKO` int(11) DEFAULT NULL,
  `registro_usuario` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE `anuncio` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `imagen` blob DEFAULT NULL,
  `registro_usuario` varchar(500) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

CREATE TABLE `clasificacion` (
  `id` bigint(20) NOT NULL,
  `nombre_clasificacion` varchar(500) DEFAULT NULL,
  `descripcion_clasificacion` text DEFAULT NULL,
  `clasificacion_raiz` varchar(500) DEFAULT NULL,
  `icono` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion_actividad`
--

CREATE TABLE `clasificacion_actividad` (
  `id` bigint(20) NOT NULL,
  `clasificacion` bigint(20) DEFAULT NULL,
  `actividad` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` bigint(20) NOT NULL,
  `registro_usuario` varchar(500) DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `comentario_relacionado` varchar(500) DEFAULT NULL,
  `cerrado_comentar` tinyint(1) DEFAULT NULL,
  `numero_denuncias` int(11) DEFAULT NULL,
  `fecha_denuncia` date DEFAULT NULL,
  `bloqueado` tinyint(1) DEFAULT NULL,
  `fecha_bloqueo` date DEFAULT NULL,
  `motivo_bloqueo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` bigint(20) NOT NULL,
  `actividad` bigint(20) DEFAULT NULL,
  `comentario` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` bigint(20) NOT NULL,
  `nombre_etiqueta` varchar(500) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas_actividad`
--

CREATE TABLE `etiquetas_actividad` (
  `id` bigint(20) NOT NULL,
  `etiqueta` bigint(20) DEFAULT NULL,
  `actividad` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas_anuncio`
--

CREATE TABLE `etiquetas_anuncio` (
  `id` bigint(20) NOT NULL,
  `etiqueta` varchar(500) DEFAULT NULL,
  `anuncio` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `nombre_archivo` varchar(500) DEFAULT NULL,
  `extension` varchar(500) DEFAULT NULL,
  `ruta` varchar(500) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_actividad`
--

CREATE TABLE `imagenes_actividad` (
  `id` bigint(20) NOT NULL,
  `imagen` bigint(20) DEFAULT NULL,
  `actividad` varchar(500) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` bigint(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `cod_clase` varchar(500) DEFAULT NULL,
  `texto` text DEFAULT NULL,
  `usuario_origen` bigint(20) DEFAULT NULL,
  `usuario_destino` bigint(20) DEFAULT NULL,
  `actividad` bigint(20) DEFAULT NULL,
  `comentario` bigint(20) DEFAULT NULL,
  `fecha_lectura` date DEFAULT NULL,
  `fecha_borrado` date DEFAULT NULL,
  `fecha_aceptacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante`
--

CREATE TABLE `participante` (
  `id` bigint(20) NOT NULL,
  `actividad` bigint(20) DEFAULT NULL,
  `usuario` varchar(500) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `cancelado` tinyint(1) DEFAULT NULL,
  `fecha_cancelacion` date DEFAULT NULL,
  `motivo_cancelacion` text DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patrocinios_actividad`
--

CREATE TABLE `patrocinios_actividad` (
  `id` bigint(20) NOT NULL,
  `actividad` bigint(20) DEFAULT NULL,
  `anuncio` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_acciones`
--

CREATE TABLE `registro_acciones` (
  `id` bigint(20) NOT NULL,
  `usuario_accion` varchar(500) DEFAULT NULL,
  `fecha_accion` datetime DEFAULT NULL,
  `accion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_usuario`
--

CREATE TABLE `registro_usuario` (
  `id` bigint(20) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `usuario_creador` varchar(500) DEFAULT NULL,
  `fecha_mod` date DEFAULT NULL,
  `usuario_mod` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) NOT NULL,
  `nombre_usuario` varchar(500) DEFAULT NULL,
  `rol` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimientos`
--

CREATE TABLE `seguimientos` (
  `id` bigint(20) NOT NULL,
  `fecha_seguimiento` date DEFAULT NULL,
  `actividad` bigint(20) DEFAULT NULL,
  `usuario_seguidor` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id` bigint(20) NOT NULL,
  `clase_ubicacion` int(11) DEFAULT NULL,
  `nombre_ubicacion` varchar(500) DEFAULT NULL,
  `ubicacion_raiz` varchar(500) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `nick` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `nombre` varchar(500) DEFAULT NULL,
  `apellidos` varchar(500) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `ubicacion` varchar(500) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `registro_confirmado` tinyint(1) DEFAULT NULL,
  `revisado` tinyint(1) DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL,
  `intentos_acceso` bigint(20) DEFAULT NULL,
  `bloqueado` tinyint(1) DEFAULT NULL,
  `fecha_bloqueo` date DEFAULT NULL,
  `motivo_bloqueo` varchar(500) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_4` (`clasificacion`),
  ADD KEY `index_5` (`imagenes_adicionales`),
  ADD KEY `index_6` (`patrocinios_actividad`),
  ADD KEY `index_7` (`comentarios`),
  ADD KEY `index_8` (`registro_usuario`);

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_14` (`icono`);

--
-- Indices de la tabla `clasificacion_actividad`
--
ALTER TABLE `clasificacion_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_12` (`clasificacion`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_15` (`comentario`),
  ADD KEY `index_16` (`actividad`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etiquetas_actividad`
--
ALTER TABLE `etiquetas_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_13` (`etiqueta`);

--
-- Indices de la tabla `etiquetas_anuncio`
--
ALTER TABLE `etiquetas_anuncio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_22` (`anuncio`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imagenes_actividad`
--
ALTER TABLE `imagenes_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_21` (`imagen`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_17` (`usuario_origen`),
  ADD KEY `index_18` (`usuario_destino`),
  ADD KEY `index_19` (`actividad`),
  ADD KEY `index_20` (`comentario`);

--
-- Indices de la tabla `participante`
--
ALTER TABLE `participante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_3` (`actividad`);

--
-- Indices de la tabla `patrocinios_actividad`
--
ALTER TABLE `patrocinios_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_1` (`anuncio`),
  ADD KEY `index_2` (`actividad`);

--
-- Indices de la tabla `registro_acciones`
--
ALTER TABLE `registro_acciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_9` (`nombre_usuario`);

--
-- Indices de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_10` (`actividad`),
  ADD KEY `index_11` (`usuario_seguidor`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nick` (`nick`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clasificacion_actividad`
--
ALTER TABLE `clasificacion_actividad`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiquetas_actividad`
--
ALTER TABLE `etiquetas_actividad`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiquetas_anuncio`
--
ALTER TABLE `etiquetas_anuncio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_actividad`
--
ALTER TABLE `imagenes_actividad`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `participante`
--
ALTER TABLE `participante`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patrocinios_actividad`
--
ALTER TABLE `patrocinios_actividad`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_acciones`
--
ALTER TABLE `registro_acciones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_clasificacion_fk` FOREIGN KEY (`clasificacion`) REFERENCES `clasificacion_actividad` (`id`),
  ADD CONSTRAINT `actividad_comentarios_fk` FOREIGN KEY (`comentarios`) REFERENCES `comentarios` (`id`),
  ADD CONSTRAINT `actividad_imagenes_adicionales_fk` FOREIGN KEY (`imagenes_adicionales`) REFERENCES `imagenes_actividad` (`id`),
  ADD CONSTRAINT `actividad_patrocinios_actividad_fk` FOREIGN KEY (`patrocinios_actividad`) REFERENCES `patrocinios_actividad` (`id`),
  ADD CONSTRAINT `actividad_registro_usuario_fk` FOREIGN KEY (`registro_usuario`) REFERENCES `registro_usuario` (`id`);

--
-- Filtros para la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD CONSTRAINT `clasificacion_icono_fk` FOREIGN KEY (`icono`) REFERENCES `imagen` (`id`);

--
-- Filtros para la tabla `clasificacion_actividad`
--
ALTER TABLE `clasificacion_actividad`
  ADD CONSTRAINT `clasificacion_actividad_clasificacion_fk` FOREIGN KEY (`clasificacion`) REFERENCES `clasificacion` (`id`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_actividad_fk` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`id`),
  ADD CONSTRAINT `comentarios_comentario_fk` FOREIGN KEY (`comentario`) REFERENCES `comentario` (`id`);

--
-- Filtros para la tabla `etiquetas_actividad`
--
ALTER TABLE `etiquetas_actividad`
  ADD CONSTRAINT `etiquetas_actividad_etiqueta_fk` FOREIGN KEY (`etiqueta`) REFERENCES `etiquetas` (`id`);

--
-- Filtros para la tabla `etiquetas_anuncio`
--
ALTER TABLE `etiquetas_anuncio`
  ADD CONSTRAINT `etiquetas_anuncio_anuncio_fk` FOREIGN KEY (`anuncio`) REFERENCES `anuncio` (`id`);

--
-- Filtros para la tabla `imagenes_actividad`
--
ALTER TABLE `imagenes_actividad`
  ADD CONSTRAINT `imagenes_actividad_imagen_fk` FOREIGN KEY (`imagen`) REFERENCES `imagen` (`id`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_actividad_fk` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`id`),
  ADD CONSTRAINT `notificaciones_comentario_fk` FOREIGN KEY (`comentario`) REFERENCES `comentario` (`id`),
  ADD CONSTRAINT `notificaciones_usuario_destino_fk` FOREIGN KEY (`usuario_destino`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `notificaciones_usuario_origen_fk` FOREIGN KEY (`usuario_origen`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `participante`
--
ALTER TABLE `participante`
  ADD CONSTRAINT `participante_actividad_fk` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`id`);

--
-- Filtros para la tabla `patrocinios_actividad`
--
ALTER TABLE `patrocinios_actividad`
  ADD CONSTRAINT `patrocinios_actividad_actividad_fk` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`id`),
  ADD CONSTRAINT `patrocinios_actividad_anuncio_fk` FOREIGN KEY (`anuncio`) REFERENCES `anuncio` (`id`);

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_nombre_usuario_fk` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nick`);

--
-- Filtros para la tabla `seguimientos`
--
ALTER TABLE `seguimientos`
  ADD CONSTRAINT `seguimientos_actividad_fk` FOREIGN KEY (`actividad`) REFERENCES `actividad` (`id`),
  ADD CONSTRAINT `seguimientos_usuario_seguidor_fk` FOREIGN KEY (`usuario_seguidor`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
