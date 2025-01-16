-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-01-2025 a las 13:48:59
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
-- Base de datos: `actividades_eventos`
--
CREATE DATABASE IF NOT EXISTS `actividades_eventos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `actividades_eventos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACTIVIDAD`
--

DROP TABLE IF EXISTS `ACTIVIDAD`;
CREATE TABLE `ACTIVIDAD` (
  `id` bigint(19) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_celebracion` datetime DEFAULT NULL,
  `duracion_estimada` bigint(19) DEFAULT NULL,
  `lugar_celebracion` varchar(255) DEFAULT NULL,
  `detalles` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  `edad_recomendada` int(10) DEFAULT NULL,
  `votosOK` bigint(19) DEFAULT NULL,
  `votosKO` bigint(19) DEFAULT NULL,
  `maximo_participantes` int(10) DEFAULT NULL COMMENT 'si está abierta la participación y el número máximo de participantes que pueden apuntarse en la actividad, 0: No se admiten participantes, >0: Ese valor límite, -1: No hay límite máximo',
  `minimo_participantes` int(10) DEFAULT NULL COMMENT 'número de participantes apuntados para que la actividad se lleve a cabo, >=0: Ese valor mínimo, -1: No hay mínimo',
  `reserva` int(10) DEFAULT NULL COMMENT 'valor lógico para indicar si se admiten o no participantes en reserva en caso de que esté abierta la participación ',
  `participantes` int(10) DEFAULT NULL,
  `contador_visitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ACTIVIDAD`
--

INSERT INTO `ACTIVIDAD` (`id`, `titulo`, `descripcion`, `fecha_celebracion`, `duracion_estimada`, `lugar_celebracion`, `detalles`, `notas`, `edad_recomendada`, `votosOK`, `votosKO`, `maximo_participantes`, `minimo_participantes`, `reserva`, `participantes`, `contador_visitas`) VALUES
(1, 'Concierto de Música', 'Un concierto en el parque con diferentes bandas locales.', '2025-02-20 00:00:00', 120, 'Parque Central', 'Trae tu manta y disfruta del evento.', 'Evento gratuito para todas las edades.', 0, 100, 10, 500, 50, 1, 150, 2),
(2, 'Torneo de Futbol', 'Competencia de futbol entre equipos locales.', '2025-03-15 00:00:00', 180, 'Estadio Municipal', '¡Inscríbete y forma tu equipo!', 'La inscripción está abierta hasta el 1 de marzo.', 12, 200, 5, 10, 2, 1, 8, 0),
(5, 'Feria del Libro', 'Feria anual con expositores locales y nacionales', '2025-04-15 00:00:00', 480, 'Plaza Mayor', 'Presentaciones de libros y firmas de autores', 'Evento cultural con actividades para niños', 0, 150, 8, 1000, 0, 1, 300, 0),
(7, 'Festival Gastronómico', 'Muestra de la gastronomía local y regional', '2025-05-20 00:00:00', 360, 'Recinto Ferial', 'Degustaciones y talleres culinarios', 'Participan restaurantes locales', 0, 280, 15, 800, 100, 1, 500, 0),
(8, 'Carrera Popular', 'Carrera urbana 10Km', '2025-06-10 00:00:00', 180, 'Centro Ciudad', 'Recorrido por el casco histórico', 'Incluye categorías infantiles', 12, 400, 20, 1000, 200, 1, 750, 0),
(9, 'Teatro en la Calle', 'Festival de artes escénicas', '2025-07-01 00:00:00', 240, 'Casco Antiguo', 'Actuaciones de compañías locales', 'Espectáculos gratuitos', 0, 180, 5, 300, 0, 0, 250, 0),
(10, 'Exposición de Arte Local', 'Muestra de artistas contemporáneos', '2025-08-05 00:00:00', 720, 'Centro Cultural', 'Pinturas y esculturas locales', 'Visitas guiadas disponibles', 0, 90, 10, 200, 0, 1, 150, 1),
(11, 'Mercado Medieval', 'Recreación histórica y mercado tradicional', '2025-09-15 00:00:00', 480, 'Plaza del Ayuntamiento', 'Artesanía y espectáculos medievales', 'Ambiente familiar', 0, 320, 25, 2000, 0, 1, 1500, 0),
(12, 'Torneo de Pádel', 'Competición amateur por categorías', '2025-10-01 00:00:00', 480, 'Club Deportivo Municipal', 'Todas las categorías y niveles', 'Inscripción por parejas', 16, 150, 12, 64, 32, 1, 48, 0),
(13, 'Festival de Jazz', 'Conciertos de jazz y blues', '2025-11-10 00:00:00', 240, 'Teatro Municipal', 'Artistas nacionales e internacionales', 'Aforo limitado', 0, 200, 8, 400, 100, 1, 350, 0),
(14, 'Navidad en la Ciudad', 'Actividades navideñas familiares', '2025-12-20 00:00:00', 720, 'Centro Ciudad', 'Mercadillo navideño y actividades infantiles', 'Programación especial', 0, 450, 20, 1000, 0, 1, 800, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACTIVIDAD_UBICACION`
--

DROP TABLE IF EXISTS `ACTIVIDAD_UBICACION`;
CREATE TABLE `ACTIVIDAD_UBICACION` (
  `ACTIVIDADid` bigint(19) NOT NULL,
  `UBICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ACTIVIDAD_UBICACION`
--

INSERT INTO `ACTIVIDAD_UBICACION` (`ACTIVIDADid`, `UBICACIONid`) VALUES
(1, 1),
(2, 2),
(5, 1),
(7, 2),
(8, 1),
(9, 1),
(10, 2),
(11, 1),
(12, 2),
(13, 2),
(14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ANUNCIO`
--

DROP TABLE IF EXISTS `ANUNCIO`;
CREATE TABLE `ANUNCIO` (
  `id` bigint(19) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `registro_de_usuario` int(10) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ANUNCIO`
--

INSERT INTO `ANUNCIO` (`id`, `titulo`, `texto`, `registro_de_usuario`, `notas`) VALUES
(1, 'Apertura de Inscripciones', 'Inscripciones abiertas para el torneo de futbol, ¡apúntate ya!', 1, 'Plazo hasta el 1 de marzo'),
(2, 'Cambio de lugar', 'El concierto de música se moverá al Auditorio Municipal debido a previsiones de lluvia.', 2, 'Nuevo lugar confirmado.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ANUNCIO_ACTIVIDAD`
--

DROP TABLE IF EXISTS `ANUNCIO_ACTIVIDAD`;
CREATE TABLE `ANUNCIO_ACTIVIDAD` (
  `ANUNCIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ANUNCIO_ACTIVIDAD`
--

INSERT INTO `ANUNCIO_ACTIVIDAD` (`ANUNCIOid`, `ACTIVIDADid`) VALUES
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

DROP TABLE IF EXISTS `clasificacion`;
CREATE TABLE `clasificacion` (
  `id` bigint(19) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `clasificacion_raiz` varchar(255) DEFAULT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clasificacion`
--

INSERT INTO `clasificacion` (`id`, `nombre`, `descripcion`, `icono`, `clasificacion_raiz`, `ACTIVIDADid`) VALUES
(1, 'Familiar', 'Apto para todo público', 'icon_familiar.png', 'Familiar', 1),
(2, 'Competencia', 'Actividad competitiva', 'icon_competencia.png', 'Deporte', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CLASIFICACION_ACTIVIDAD`
--

DROP TABLE IF EXISTS `CLASIFICACION_ACTIVIDAD`;
CREATE TABLE `CLASIFICACION_ACTIVIDAD` (
  `CLASIFICACIONid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `CLASIFICACION_ACTIVIDAD`
--

INSERT INTO `CLASIFICACION_ACTIVIDAD` (`CLASIFICACIONid`, `ACTIVIDADid`) VALUES
(1, 1),
(1, 5),
(1, 7),
(1, 9),
(1, 10),
(1, 11),
(1, 13),
(1, 14),
(2, 2),
(2, 8),
(2, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE `comentario` (
  `id` bigint(19) NOT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `comentario_relacionado` bigint(19) DEFAULT NULL,
  `cerrado_comentario` int(10) DEFAULT NULL,
  `numero_de_denuncias` int(10) DEFAULT NULL,
  `fecha_bloque` datetime DEFAULT NULL,
  `motivos_bloqueo` varchar(255) DEFAULT NULL,
  `USUARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `texto`, `comentario_relacionado`, `cerrado_comentario`, `numero_de_denuncias`, `fecha_bloque`, `motivos_bloqueo`, `USUARIOid`, `ACTIVIDADid`) VALUES
(1, '¡Qué evento tan increíble!', NULL, 0, 0, '2025-01-05 00:00:00', NULL, 1, 1),
(2, 'No me gustó el cambio de lugar', NULL, 1, 0, '2025-01-06 00:00:00', 'Comentario bloqueado', 2, 2),
(3, '¡Me encanta que se celebren estos eventos en nuestra ciudad!', NULL, 0, 0, '2025-01-16 22:30:56', NULL, 1, 14),
(4, 'A mi también, pero deberían revisar los precios de algunos productos ????', 3, 0, 0, '2025-01-16 22:31:50', NULL, 3, 14),
(5, 'Sí, además en estas épocas se agradece la calidez de la gente!!!!', 3, 0, 0, '2025-01-16 22:32:54', NULL, 2, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIO_ACTIVIDAD`
--

DROP TABLE IF EXISTS `COMENTARIO_ACTIVIDAD`;
CREATE TABLE `COMENTARIO_ACTIVIDAD` (
  `COMENTARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `COMENTARIO_ACTIVIDAD`
--

INSERT INTO `COMENTARIO_ACTIVIDAD` (`COMENTARIOid`, `ACTIVIDADid`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIO_USUARIO`
--

DROP TABLE IF EXISTS `COMENTARIO_USUARIO`;
CREATE TABLE `COMENTARIO_USUARIO` (
  `COMENTARIOid` bigint(19) NOT NULL,
  `USUARIOid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CREA`
--

DROP TABLE IF EXISTS `CREA`;
CREATE TABLE `CREA` (
  `USUARIOid` bigint(19) NOT NULL,
  `NOTIFICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

DROP TABLE IF EXISTS `estado`;
CREATE TABLE `estado` (
  `id` bigint(19) NOT NULL,
  `terminada` int(10) DEFAULT NULL COMMENT '(0:No, 1:Realizada, 2:Suspendida, 3:Cancelada por inadecuada),  ',
  `fecha_terminacion` datetime DEFAULT NULL,
  `motivo_terminacion` varchar(255) DEFAULT NULL,
  `numero_denuncias` int(10) DEFAULT NULL,
  `fecha_primera_denuncia` datetime DEFAULT NULL,
  `bloqueada` int(10) DEFAULT NULL,
  `fecha_bloqueo` datetime DEFAULT NULL,
  `motivos_bloqueo` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `terminada`, `fecha_terminacion`, `motivo_terminacion`, `numero_denuncias`, `fecha_primera_denuncia`, `bloqueada`, `fecha_bloqueo`, `motivos_bloqueo`, `notas`, `ACTIVIDADid`) VALUES
(1, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, 'Actividad en proceso', 1),
(2, 3, '2025-03-01 00:00:00', 'Cancelada por lluvia', 2, '2025-02-28 00:00:00', 1, '2025-02-28 00:00:00', 'Condiciones climáticas adversas', 'Evento cancelado debido a la tormenta', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTADO_ACTIVIDAD`
--

DROP TABLE IF EXISTS `ESTADO_ACTIVIDAD`;
CREATE TABLE `ESTADO_ACTIVIDAD` (
  `ESTADOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ESTADO_ACTIVIDAD`
--

INSERT INTO `ESTADO_ACTIVIDAD` (`ESTADOid`, `ACTIVIDADid`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ETIQUETAS`
--

DROP TABLE IF EXISTS `ETIQUETAS`;
CREATE TABLE `ETIQUETAS` (
  `id` bigint(19) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ETIQUETAS`
--

INSERT INTO `ETIQUETAS` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Deporte', 'Actividades deportivas y competencias'),
(2, 'Música', 'Eventos relacionados con música en vivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ETIQUETAS_ACTIVIDAD`
--

DROP TABLE IF EXISTS `ETIQUETAS_ACTIVIDAD`;
CREATE TABLE `ETIQUETAS_ACTIVIDAD` (
  `ETIQUETASid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ETIQUETAS_ACTIVIDAD`
--

INSERT INTO `ETIQUETAS_ACTIVIDAD` (`ETIQUETASid`, `ACTIVIDADid`) VALUES
(1, 2),
(1, 8),
(1, 12),
(2, 1),
(2, 13),
(2, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `HISTORIAL`
--

DROP TABLE IF EXISTS `HISTORIAL`;
CREATE TABLE `HISTORIAL` (
  `id` bigint(19) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IMAGEN`
--

DROP TABLE IF EXISTS `IMAGEN`;
CREATE TABLE `IMAGEN` (
  `id` bigint(19) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `nombre_Archivo` varchar(255) DEFAULT NULL,
  `ruta_archivo` varchar(80) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `IMAGEN`
--

INSERT INTO `IMAGEN` (`id`, `titulo`, `descripcion`, `nombre_Archivo`, `ruta_archivo`, `extension`, `notas`) VALUES
(1, '1', 'Vista panorámica del evento', 'concierto_parque', NULL, 'jpg', 'Imagen tomada desde el escenario principal.'),
(2, '2', 'Equipo de futbol jugando', 'torneo_futbol', NULL, 'png', 'Imagen durante la competencia del torneo.'),
(3, NULL, NULL, 'navidad', NULL, 'jpg', NULL),
(4, NULL, NULL, 'carrera', NULL, 'jpg', NULL),
(5, NULL, NULL, 'medieval', NULL, 'jpg', NULL),
(6, NULL, NULL, 'gastronomica', NULL, 'webp', NULL),
(7, NULL, NULL, 'jazz', NULL, 'webp', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IMAGEN_ACTIVIDAD`
--

DROP TABLE IF EXISTS `IMAGEN_ACTIVIDAD`;
CREATE TABLE `IMAGEN_ACTIVIDAD` (
  `IMAGENid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `orden` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `IMAGEN_ACTIVIDAD`
--

INSERT INTO `IMAGEN_ACTIVIDAD` (`IMAGENid`, `ACTIVIDADid`, `orden`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 14, 1),
(4, 8, 1),
(5, 11, 1),
(6, 7, 1),
(7, 13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `NOTIFICACION`
--

DROP TABLE IF EXISTS `NOTIFICACION`;
CREATE TABLE `NOTIFICACION` (
  `id` bigint(19) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `codigo_de_clase` varchar(255) DEFAULT NULL COMMENT 'A: Aviso, N: Notificación, D: Denuncia, C: Consulta),  ',
  `fecha_lectura` datetime DEFAULT NULL,
  `fecha_borrado` datetime DEFAULT NULL,
  `fecha_aceptacion` datetime DEFAULT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `USUARIOid` bigint(19) NOT NULL,
  `USUARIOid2` bigint(19) NOT NULL,
  `texto` varchar(500) NOT NULL COMMENT 'Texto de la notificacion '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `NOTIFICACION`
--

INSERT INTO `NOTIFICACION` (`id`, `fecha`, `codigo_de_clase`, `fecha_lectura`, `fecha_borrado`, `fecha_aceptacion`, `ACTIVIDADid`, `USUARIOid`, `USUARIOid2`, `texto`) VALUES
(1, '2025-01-09 12:35:56', 'SOLICITUD_BAJA', NULL, NULL, NULL, 1, 1, 1, ''),
(2, '2025-01-09 12:35:56', 'SOLICITUD_BAJA', NULL, NULL, NULL, 1, 1, 1, ''),
(3, '2025-01-10 00:00:00', 'AVISO', NULL, NULL, NULL, 1, 1, 1, 'Notificación de prueba para el usuario 1'),
(4, '2025-01-11 00:00:00', 'NOTIFICACIÓN', NULL, NULL, NULL, 2, 2, 2, 'Notificación de prueba para el usuario 2'),
(5, '2025-01-12 00:00:00', 'DENUNCIA', NULL, NULL, NULL, 1, 2, 3, 'Notificación de prueba para el usuario 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PARTICIPA`
--

DROP TABLE IF EXISTS `PARTICIPA`;
CREATE TABLE `PARTICIPA` (
  `USUARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `fecha_inscripcion` datetime DEFAULT NULL,
  `cancelado` int(10) DEFAULT NULL,
  `fecha_cancelacion` datetime DEFAULT NULL,
  `motivos_cancelacion` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `PARTICIPA`
--

INSERT INTO `PARTICIPA` (`USUARIOid`, `ACTIVIDADid`, `fecha_inscripcion`, `cancelado`, `fecha_cancelacion`, `motivos_cancelacion`, `notas`) VALUES
(1, 2, '2025-01-02 00:00:00', 0, NULL, NULL, 'Participante confirmado en el torneo'),
(2, 1, '2025-01-03 00:00:00', 1, '2025-01-04 00:00:00', 'Motivos personales', 'Canceló su inscripción al evento de música'),
(3, 1, '2025-01-07 00:00:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PATROCINA`
--

DROP TABLE IF EXISTS `PATROCINA`;
CREATE TABLE `PATROCINA` (
  `USUARIOid` bigint(19) NOT NULL,
  `ANUNCIOid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RECIBE`
--

DROP TABLE IF EXISTS `RECIBE`;
CREATE TABLE `RECIBE` (
  `USUARIOid` bigint(19) NOT NULL,
  `NOTIFICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_acciones`
--

DROP TABLE IF EXISTS `registro_acciones`;
CREATE TABLE `registro_acciones` (
  `id` int(11) NOT NULL,
  `fecha_accion` datetime NOT NULL,
  `accion` varchar(500) NOT NULL,
  `usuario_accion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registro_acciones`
--

INSERT INTO `registro_acciones` (`id`, `fecha_accion`, `accion`, `usuario_accion`) VALUES
(1, '2025-01-13 10:50:29', 'User logged out', 'admin'),
(2, '2025-01-13 10:51:48', 'User registered', 'adminadmin'),
(3, '2025-01-13 10:52:04', 'User logged out', 'adminadmin'),
(4, '2025-01-13 10:55:09', 'User registered', 'pepe'),
(5, '2025-01-13 10:58:59', 'User logged out', 'pepe'),
(6, '2025-01-13 10:59:55', 'User logged in', 'user1'),
(7, '2025-01-13 11:00:20', 'User logged out', 'user1'),
(8, '2025-01-13 11:00:31', 'User logged in', 'user2'),
(9, '2025-01-13 11:00:48', 'User logged out', 'user2'),
(10, '2025-01-13 11:01:01', 'User logged in', 'user5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ROLES`
--

DROP TABLE IF EXISTS `ROLES`;
CREATE TABLE `ROLES` (
  `id` bigint(19) NOT NULL,
  `nombre_rol` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ROLES`
--

INSERT INTO `ROLES` (`id`, `nombre_rol`, `descripcion`) VALUES
(1, 'Normal', 'Usuario que puede buscar y visualizar actividades públicas y privadas, gestionar su perfil, recibir notificaciones, comunicarse con moderadores o administradores, gestionar sus propias actividades, dar seguimiento a actividades, participar en ellas y gestionar comentarios asociados.'),
(2, 'Moderador', 'Usuario que colabora con la web moderando actividades y comentarios en una o varias áreas geográficas.'),
(3, 'Patrocinador', 'Usuario que gestiona sus propios anuncios, actividades patrocinadas y participantes. Su registro requiere un proceso especial o la creación previa por un administrador, con acceso diferenciado a la aplicación.'),
(4, 'Administrador', 'Usuario que mantiene los datos del sistema, gestiona usuarios, actividades, categorías, áreas, ubicaciones, patrocinios y configuración. Puede realizar y restaurar copias de seguridad.'),
(5, 'SysAdmin', 'Programador de la aplicación o administrador general del sistema. Tiene acceso sin restricciones a todas las funciones y puede activar cualquier rol para trabajar como un usuario de ese tipo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SIGUE`
--

DROP TABLE IF EXISTS `SIGUE`;
CREATE TABLE `SIGUE` (
  `USUARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `fecha_seguimiento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `SIGUE`
--

INSERT INTO `SIGUE` (`USUARIOid`, `ACTIVIDADid`, `fecha_seguimiento`) VALUES
(1, 1, '2025-01-01 00:00:00'),
(2, 2, '2025-01-02 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UBICACION`
--

DROP TABLE IF EXISTS `UBICACION`;
CREATE TABLE `UBICACION` (
  `id` bigint(19) NOT NULL,
  `clase_de_ubicacion` int(10) DEFAULT NULL,
  `ubicacion_raiz` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `notas_de_como_llegar` varchar(255) DEFAULT NULL,
  `notas_de_donde_aparcar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `UBICACION`
--

INSERT INTO `UBICACION` (`id`, `clase_de_ubicacion`, `ubicacion_raiz`, `notas`, `direccion`, `notas_de_como_llegar`, `notas_de_donde_aparcar`) VALUES
(1, 1, 'Centro Cultural', 'Ubicado en el centro de la ciudad.', 'Calle Principal 123', 'Cerca de la estación de metro, salida A.', 'Aparcamiento gratuito disponible en la zona'),
(2, 2, 'Auditorio Municipal', 'Salón de eventos espacioso.', 'Avenida 7, No. 45', 'A 5 minutos a pie de la estación de autobuses.', 'Parqueo limitado, se recomienda llegar temprano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO`
--

DROP TABLE IF EXISTS `USUARIO`;
CREATE TABLE `USUARIO` (
  `id` bigint(19) NOT NULL,
  `nick` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `activo` int(10) DEFAULT NULL,
  `fecha_registor` datetime DEFAULT NULL,
  `registro_confirmado` int(10) DEFAULT NULL,
  `fecha_bloqueo` datetime DEFAULT NULL,
  `motivo_bloqueo` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`id`, `nick`, `password`, `email`, `nombre`, `apellidos`, `fecha_nacimiento`, `activo`, `fecha_registor`, `registro_confirmado`, `fecha_bloqueo`, `motivo_bloqueo`, `notas`, `token`) VALUES
(1, 'user1', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user1@example.com', 'Juan', 'Pérez', '1990-06-15', 1, '2025-01-01 00:00:00', 1, NULL, NULL, 'Activo en el sistema', ''),
(2, 'user2', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user2@example.com', 'María', 'Gómez', '1985-02-10', 1, '2025-01-02 00:00:00', 1, NULL, NULL, 'Interesado en actividades culturales', ''),
(3, 'user3', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user3@example.com', 'Paco', 'Ramírez Hidalgo', '2025-01-07', 1, '2025-01-14 00:00:00', 1, '2025-01-22 00:00:00', NULL, NULL, ''),
(4, 'user4', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user4@example.com', 'Carlos', 'Sánchez', '1992-04-10', 1, '2025-01-04 00:00:00', 1, NULL, NULL, 'Activo en el sistema', ''),
(5, 'user5', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user5@example.com', 'Ana', 'Martínez', '1988-11-23', 1, '2025-01-05 00:00:00', 1, NULL, NULL, 'Interesada en eventos deportivos', ''),
(6, 'user6', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user6@example.com', 'Luis', 'García', '1995-07-19', 1, '2025-01-06 00:00:00', 1, NULL, NULL, 'Participante activo en actividades culturales', ''),
(7, 'user7', '$2y$13$zSAbxTCf9smL5YuwUSI6feAB8tvFt/JgWB5sbMCBa7jlg9tW4GhyO', 'user7@example.com', 'Elena', 'Rodríguez', '1993-09-30', 1, '2025-01-07 00:00:00', 1, NULL, NULL, 'Interesada en actividades al aire libre', ''),
(8, 'admin', '$2y$13$3gDQb8HDsjmmRTiJODekHer6bBrTK0xX1uwhMzEam0Uy9e7p.xnfK', 'admin@gmail.es', 'admin', 'admin', '2002-01-10', 1, '2025-01-13 10:42:39', NULL, NULL, NULL, NULL, 'WVU1pVvGB3xsqtMEF7xD9QfwM7aNInOM_1736761360');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_COMENTARIO`
--

DROP TABLE IF EXISTS `USUARIO_COMENTARIO`;
CREATE TABLE `USUARIO_COMENTARIO` (
  `COMENTARIOid` bigint(19) NOT NULL,
  `USUARIOid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_HISTORIAL`
--

DROP TABLE IF EXISTS `USUARIO_HISTORIAL`;
CREATE TABLE `USUARIO_HISTORIAL` (
  `USUARIOid` bigint(19) NOT NULL,
  `HISTORIALid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_IMAGEN`
--

DROP TABLE IF EXISTS `USUARIO_IMAGEN`;
CREATE TABLE `USUARIO_IMAGEN` (
  `usuario_id` bigint(19) NOT NULL,
  `imagen_id` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `USUARIO_IMAGEN`
--

INSERT INTO `USUARIO_IMAGEN` (`usuario_id`, `imagen_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_ROLES`
--

DROP TABLE IF EXISTS `USUARIO_ROLES`;
CREATE TABLE `USUARIO_ROLES` (
  `USUARIOid` bigint(19) NOT NULL,
  `ROLESid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `USUARIO_ROLES`
--

INSERT INTO `USUARIO_ROLES` (`USUARIOid`, `ROLESid`) VALUES
(1, 5),
(2, 4),
(3, 3),
(4, 2),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_UBICACION`
--

DROP TABLE IF EXISTS `USUARIO_UBICACION`;
CREATE TABLE `USUARIO_UBICACION` (
  `USUARIOid` bigint(19) NOT NULL,
  `UBICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `USUARIO_UBICACION`
--

INSERT INTO `USUARIO_UBICACION` (`USUARIOid`, `UBICACIONid`) VALUES
(1, 1),
(2, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ACTIVIDAD`
--
ALTER TABLE `ACTIVIDAD`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ACTIVIDAD_UBICACION`
--
ALTER TABLE `ACTIVIDAD_UBICACION`
  ADD PRIMARY KEY (`ACTIVIDADid`,`UBICACIONid`),
  ADD KEY `FKACTIVIDAD_215592` (`UBICACIONid`);

--
-- Indices de la tabla `ANUNCIO`
--
ALTER TABLE `ANUNCIO`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ANUNCIO_ACTIVIDAD`
--
ALTER TABLE `ANUNCIO_ACTIVIDAD`
  ADD PRIMARY KEY (`ANUNCIOid`,`ACTIVIDADid`),
  ADD KEY `FKANUNCIO_AC683805` (`ACTIVIDADid`);

--
-- Indices de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ACTIVIDAD_CLASIFICACION` (`ACTIVIDADid`);

--
-- Indices de la tabla `CLASIFICACION_ACTIVIDAD`
--
ALTER TABLE `CLASIFICACION_ACTIVIDAD`
  ADD PRIMARY KEY (`CLASIFICACIONid`,`ACTIVIDADid`),
  ADD KEY `FKCLASIFICAC873129` (`ACTIVIDADid`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `USUARIO_COMENTARIO` (`USUARIOid`),
  ADD KEY `ACTIVIDAD_COMENTARIO` (`ACTIVIDADid`);

--
-- Indices de la tabla `COMENTARIO_ACTIVIDAD`
--
ALTER TABLE `COMENTARIO_ACTIVIDAD`
  ADD PRIMARY KEY (`COMENTARIOid`,`ACTIVIDADid`),
  ADD KEY `FKCOMENTARIO875373` (`ACTIVIDADid`);

--
-- Indices de la tabla `COMENTARIO_USUARIO`
--
ALTER TABLE `COMENTARIO_USUARIO`
  ADD PRIMARY KEY (`COMENTARIOid`,`USUARIOid`),
  ADD KEY `FKCOMENTARIO530790` (`USUARIOid`);

--
-- Indices de la tabla `CREA`
--
ALTER TABLE `CREA`
  ADD PRIMARY KEY (`USUARIOid`,`NOTIFICACIONid`),
  ADD KEY `FKCREA945987` (`NOTIFICACIONid`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ACTIVIDAD_ESTADO` (`ACTIVIDADid`);

--
-- Indices de la tabla `ESTADO_ACTIVIDAD`
--
ALTER TABLE `ESTADO_ACTIVIDAD`
  ADD PRIMARY KEY (`ESTADOid`,`ACTIVIDADid`),
  ADD KEY `FKESTADO_ACT755533` (`ACTIVIDADid`);

--
-- Indices de la tabla `ETIQUETAS`
--
ALTER TABLE `ETIQUETAS`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ETIQUETAS_ACTIVIDAD`
--
ALTER TABLE `ETIQUETAS_ACTIVIDAD`
  ADD PRIMARY KEY (`ETIQUETASid`,`ACTIVIDADid`),
  ADD KEY `FKETIQUETAS_815077` (`ACTIVIDADid`);

--
-- Indices de la tabla `HISTORIAL`
--
ALTER TABLE `HISTORIAL`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `IMAGEN`
--
ALTER TABLE `IMAGEN`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `IMAGEN_ACTIVIDAD`
--
ALTER TABLE `IMAGEN_ACTIVIDAD`
  ADD PRIMARY KEY (`IMAGENid`,`ACTIVIDADid`),
  ADD KEY `FKIMAGEN_ACT974500` (`ACTIVIDADid`);

--
-- Indices de la tabla `NOTIFICACION`
--
ALTER TABLE `NOTIFICACION`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ACTIVIDAD_NOTIFICACION` (`ACTIVIDADid`);

--
-- Indices de la tabla `PARTICIPA`
--
ALTER TABLE `PARTICIPA`
  ADD PRIMARY KEY (`USUARIOid`,`ACTIVIDADid`),
  ADD KEY `FKPARTICIPA722371` (`ACTIVIDADid`);

--
-- Indices de la tabla `PATROCINA`
--
ALTER TABLE `PATROCINA`
  ADD PRIMARY KEY (`USUARIOid`,`ANUNCIOid`),
  ADD KEY `FKPATROCINA833079` (`ANUNCIOid`);

--
-- Indices de la tabla `RECIBE`
--
ALTER TABLE `RECIBE`
  ADD PRIMARY KEY (`USUARIOid`,`NOTIFICACIONid`),
  ADD KEY `FKRECIBE718598` (`NOTIFICACIONid`);

--
-- Indices de la tabla `registro_acciones`
--
ALTER TABLE `registro_acciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ROLES`
--
ALTER TABLE `ROLES`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `SIGUE`
--
ALTER TABLE `SIGUE`
  ADD PRIMARY KEY (`USUARIOid`,`ACTIVIDADid`),
  ADD KEY `FKSIGUE658643` (`ACTIVIDADid`);

--
-- Indices de la tabla `UBICACION`
--
ALTER TABLE `UBICACION`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `USUARIO_COMENTARIO`
--
ALTER TABLE `USUARIO_COMENTARIO`
  ADD PRIMARY KEY (`COMENTARIOid`,`USUARIOid`),
  ADD KEY `FKUSUARIO_CO313336` (`USUARIOid`);

--
-- Indices de la tabla `USUARIO_HISTORIAL`
--
ALTER TABLE `USUARIO_HISTORIAL`
  ADD PRIMARY KEY (`USUARIOid`,`HISTORIALid`),
  ADD KEY `FKUSUARIO_HI577720` (`HISTORIALid`);

--
-- Indices de la tabla `USUARIO_IMAGEN`
--
ALTER TABLE `USUARIO_IMAGEN`
  ADD PRIMARY KEY (`usuario_id`,`imagen_id`),
  ADD KEY `fk_usuario` (`usuario_id`),
  ADD KEY `fk_imagen` (`imagen_id`);

--
-- Indices de la tabla `USUARIO_ROLES`
--
ALTER TABLE `USUARIO_ROLES`
  ADD PRIMARY KEY (`USUARIOid`,`ROLESid`),
  ADD KEY `FKUSUARIO_RO928803` (`ROLESid`);

--
-- Indices de la tabla `USUARIO_UBICACION`
--
ALTER TABLE `USUARIO_UBICACION`
  ADD PRIMARY KEY (`USUARIOid`,`UBICACIONid`),
  ADD KEY `FKUSUARIO_UB925726` (`UBICACIONid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ACTIVIDAD`
--
ALTER TABLE `ACTIVIDAD`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ANUNCIO`
--
ALTER TABLE `ANUNCIO`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ETIQUETAS`
--
ALTER TABLE `ETIQUETAS`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `HISTORIAL`
--
ALTER TABLE `HISTORIAL`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `IMAGEN`
--
ALTER TABLE `IMAGEN`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `NOTIFICACION`
--
ALTER TABLE `NOTIFICACION`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `registro_acciones`
--
ALTER TABLE `registro_acciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ROLES`
--
ALTER TABLE `ROLES`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `UBICACION`
--
ALTER TABLE `UBICACION`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ACTIVIDAD_UBICACION`
--
ALTER TABLE `ACTIVIDAD_UBICACION`
  ADD CONSTRAINT `FKACTIVIDAD_215592` FOREIGN KEY (`UBICACIONid`) REFERENCES `UBICACION` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKACTIVIDAD_400498` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ANUNCIO_ACTIVIDAD`
--
ALTER TABLE `ANUNCIO_ACTIVIDAD`
  ADD CONSTRAINT `FKANUNCIO_AC440486` FOREIGN KEY (`ANUNCIOid`) REFERENCES `ANUNCIO` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKANUNCIO_AC683805` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD CONSTRAINT `ACTIVIDAD_CLASIFICACION` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `CLASIFICACION_ACTIVIDAD`
--
ALTER TABLE `CLASIFICACION_ACTIVIDAD`
  ADD CONSTRAINT `FKCLASIFICAC462280` FOREIGN KEY (`CLASIFICACIONid`) REFERENCES `CLASIFICACION` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKCLASIFICAC873129` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `ACTIVIDAD_COMENTARIO` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `USUARIO_COMENTARIO` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`);

--
-- Filtros para la tabla `COMENTARIO_ACTIVIDAD`
--
ALTER TABLE `COMENTARIO_ACTIVIDAD`
  ADD CONSTRAINT `FKCOMENTARIO307859` FOREIGN KEY (`COMENTARIOid`) REFERENCES `COMENTARIO` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKCOMENTARIO875373` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `COMENTARIO_USUARIO`
--
ALTER TABLE `COMENTARIO_USUARIO`
  ADD CONSTRAINT `FKCOMENTARIO192790` FOREIGN KEY (`COMENTARIOid`) REFERENCES `COMENTARIO` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKCOMENTARIO530790` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `CREA`
--
ALTER TABLE `CREA`
  ADD CONSTRAINT `FKCREA60709` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKCREA945987` FOREIGN KEY (`NOTIFICACIONid`) REFERENCES `NOTIFICACION` (`id`);

--
-- Filtros para la tabla `estado`
--
ALTER TABLE `estado`
  ADD CONSTRAINT `ACTIVIDAD_ESTADO` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ESTADO_ACTIVIDAD`
--
ALTER TABLE `ESTADO_ACTIVIDAD`
  ADD CONSTRAINT `FKESTADO_ACT641725` FOREIGN KEY (`ESTADOid`) REFERENCES `ESTADO` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKESTADO_ACT755533` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ETIQUETAS_ACTIVIDAD`
--
ALTER TABLE `ETIQUETAS_ACTIVIDAD`
  ADD CONSTRAINT `FKETIQUETAS_587850` FOREIGN KEY (`ETIQUETASid`) REFERENCES `ETIQUETAS` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKETIQUETAS_815077` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `IMAGEN_ACTIVIDAD`
--
ALTER TABLE `IMAGEN_ACTIVIDAD`
  ADD CONSTRAINT `FKIMAGEN_ACT674560` FOREIGN KEY (`IMAGENid`) REFERENCES `IMAGEN` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKIMAGEN_ACT974500` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `NOTIFICACION`
--
ALTER TABLE `NOTIFICACION`
  ADD CONSTRAINT `ACTIVIDAD_NOTIFICACION` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `PARTICIPA`
--
ALTER TABLE `PARTICIPA`
  ADD CONSTRAINT `FKPARTICIPA262719` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKPARTICIPA722371` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `PATROCINA`
--
ALTER TABLE `PATROCINA`
  ADD CONSTRAINT `FKPATROCINA417024` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKPATROCINA833079` FOREIGN KEY (`ANUNCIOid`) REFERENCES `ANUNCIO` (`id`);

--
-- Filtros para la tabla `RECIBE`
--
ALTER TABLE `RECIBE`
  ADD CONSTRAINT `FKRECIBE603877` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKRECIBE718598` FOREIGN KEY (`NOTIFICACIONid`) REFERENCES `NOTIFICACION` (`id`);

--
-- Filtros para la tabla `SIGUE`
--
ALTER TABLE `SIGUE`
  ADD CONSTRAINT `FKSIGUE658643` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKSIGUE881703` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `USUARIO_COMENTARIO`
--
ALTER TABLE `USUARIO_COMENTARIO`
  ADD CONSTRAINT `FKUSUARIO_CO313336` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKUSUARIO_CO934673` FOREIGN KEY (`COMENTARIOid`) REFERENCES `COMENTARIO` (`id`);

--
-- Filtros para la tabla `USUARIO_HISTORIAL`
--
ALTER TABLE `USUARIO_HISTORIAL`
  ADD CONSTRAINT `FKUSUARIO_HI577720` FOREIGN KEY (`HISTORIALid`) REFERENCES `HISTORIAL` (`id`),
  ADD CONSTRAINT `FKUSUARIO_HI668606` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`);

--
-- Filtros para la tabla `USUARIO_IMAGEN`
--
ALTER TABLE `USUARIO_IMAGEN`
  ADD CONSTRAINT `fk_imagen` FOREIGN KEY (`imagen_id`) REFERENCES `IMAGEN` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `USUARIO` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `USUARIO_ROLES`
--
ALTER TABLE `USUARIO_ROLES`
  ADD CONSTRAINT `FKUSUARIO_RO928803` FOREIGN KEY (`ROLESid`) REFERENCES `ROLES` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKUSUARIO_RO976461` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `USUARIO_UBICACION`
--
ALTER TABLE `USUARIO_UBICACION`
  ADD CONSTRAINT `FKUSUARIO_UB349019` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FKUSUARIO_UB925726` FOREIGN KEY (`UBICACIONid`) REFERENCES `UBICACION` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;