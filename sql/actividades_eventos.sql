-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-01-2025 a las 22:29:38
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACTIVIDAD`
--

CREATE TABLE `ACTIVIDAD` (
  `id` bigint(19) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_celebracion` date DEFAULT NULL,
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
  `participantes` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ACTIVIDAD`
--

INSERT INTO `ACTIVIDAD` (`id`, `titulo`, `descripcion`, `fecha_celebracion`, `duracion_estimada`, `lugar_celebracion`, `detalles`, `notas`, `edad_recomendada`, `votosOK`, `votosKO`, `maximo_participantes`, `minimo_participantes`, `reserva`, `participantes`) VALUES
(1, 'Concierto de Música', 'Un concierto en el parque con diferentes bandas locales.', '2025-02-20', 120, 'Parque Central', 'Trae tu manta y disfruta del evento.', 'Evento gratuito para todas las edades.', 0, 100, 10, 500, 50, 1, 150),
(2, 'Torneo de Futbol', 'Competencia de futbol entre equipos locales.', '2025-03-15', 180, 'Estadio Municipal', '¡Inscríbete y forma tu equipo!', 'La inscripción está abierta hasta el 1 de marzo.', 12, 200, 5, 10, 2, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ACTIVIDAD_UBICACION`
--

CREATE TABLE `ACTIVIDAD_UBICACION` (
  `ACTIVIDADid` bigint(19) NOT NULL,
  `UBICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ACTIVIDAD_UBICACION`
--

INSERT INTO `ACTIVIDAD_UBICACION` (`ACTIVIDADid`, `UBICACIONid`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ANUNCIO`
--

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
-- Estructura de tabla para la tabla `CLASIFICACION`
--

CREATE TABLE `CLASIFICACION` (
  `id` bigint(19) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `clasificacion_raiz` varchar(255) DEFAULT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `CLASIFICACION`
--

INSERT INTO `CLASIFICACION` (`id`, `nombre`, `descripcion`, `icono`, `clasificacion_raiz`, `ACTIVIDADid`) VALUES
(1, 'Familiar', 'Apto para todo público', 'icon_familiar.png', 'Familiar', 1),
(2, 'Competencia', 'Actividad competitiva', 'icon_competencia.png', 'Deporte', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CLASIFICACION_ACTIVIDAD`
--

CREATE TABLE `CLASIFICACION_ACTIVIDAD` (
  `CLASIFICACIONid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `CLASIFICACION_ACTIVIDAD`
--

INSERT INTO `CLASIFICACION_ACTIVIDAD` (`CLASIFICACIONid`, `ACTIVIDADid`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIO`
--

CREATE TABLE `COMENTARIO` (
  `id` bigint(19) NOT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `comentario_relacionado` varchar(255) DEFAULT NULL,
  `cerrado_comentario` int(10) DEFAULT NULL,
  `numero_de_denuncias` int(10) DEFAULT NULL,
  `fecha_bloque` date DEFAULT NULL,
  `motivos_bloqueo` varchar(255) DEFAULT NULL,
  `USUARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `COMENTARIO`
--

INSERT INTO `COMENTARIO` (`id`, `texto`, `comentario_relacionado`, `cerrado_comentario`, `numero_de_denuncias`, `fecha_bloque`, `motivos_bloqueo`, `USUARIOid`, `ACTIVIDADid`) VALUES
(1, '¡Qué evento tan increíble!', NULL, 0, 0, '2025-01-05', NULL, 1, 1),
(2, 'No me gustó el cambio de lugar', NULL, 1, 0, '2025-01-06', 'Comentario bloqueado', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIO_ACTIVIDAD`
--

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

CREATE TABLE `COMENTARIO_USUARIO` (
  `COMENTARIOid` bigint(19) NOT NULL,
  `USUARIOid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CREA`
--

CREATE TABLE `CREA` (
  `USUARIOid` bigint(19) NOT NULL,
  `NOTIFICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTADO`
--

CREATE TABLE `ESTADO` (
  `id` bigint(19) NOT NULL,
  `terminada` int(10) DEFAULT NULL COMMENT '(0:No, 1:Realizada, 2:Suspendida, 3:Cancelada por inadecuada),  ',
  `fecha_terminacion` date DEFAULT NULL,
  `motivo_terminacion` varchar(255) DEFAULT NULL,
  `numero_denuncias` int(10) DEFAULT NULL,
  `fecha_primera_denuncia` date DEFAULT NULL,
  `bloqueada` int(10) DEFAULT NULL,
  `fecha_bloqueo` date DEFAULT NULL,
  `motivos_bloqueo` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ESTADO`
--

INSERT INTO `ESTADO` (`id`, `terminada`, `fecha_terminacion`, `motivo_terminacion`, `numero_denuncias`, `fecha_primera_denuncia`, `bloqueada`, `fecha_bloqueo`, `motivos_bloqueo`, `notas`, `ACTIVIDADid`) VALUES
(1, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, 'Actividad en proceso', 1),
(2, 3, '2025-03-01', 'Cancelada por lluvia', 2, '2025-02-28', 1, '2025-02-28', 'Condiciones climáticas adversas', 'Evento cancelado debido a la tormenta', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTADO_ACTIVIDAD`
--

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

CREATE TABLE `ETIQUETAS_ACTIVIDAD` (
  `ETIQUETASid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ETIQUETAS_ACTIVIDAD`
--

INSERT INTO `ETIQUETAS_ACTIVIDAD` (`ETIQUETASid`, `ACTIVIDADid`) VALUES
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `HISTORIAL`
--

CREATE TABLE `HISTORIAL` (
  `id` bigint(19) NOT NULL,
  `fecha` date DEFAULT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IMAGEN`
--

CREATE TABLE `IMAGEN` (
  `id` bigint(19) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `nombre_Archivo` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `IMAGEN`
--

INSERT INTO `IMAGEN` (`id`, `titulo`, `descripcion`, `nombre_Archivo`, `extension`, `notas`) VALUES
(1, 'Paisaje', 'Vista panorámica del evento', 'concierto_parque', 'jpg', 'Imagen tomada desde el escenario principal.'),
(2, 'Foto de equipo', 'Equipo de futbol jugando', 'torneo_futbol', 'png', 'Imagen durante la competencia del torneo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IMAGEN_ACTIVIDAD`
--

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
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `NOTIFICACION`
--

CREATE TABLE `NOTIFICACION` (
  `id` bigint(19) NOT NULL,
  `fecha` date DEFAULT NULL,
  `codigo_de_clase` varchar(255) DEFAULT NULL COMMENT 'A: Aviso, N: Notificación, D: Denuncia, C: Consulta),  ',
  `fecha_lectura` date DEFAULT NULL,
  `fecha_borrado` date DEFAULT NULL,
  `fecha_aceptacion` date DEFAULT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `USUARIOid` bigint(19) NOT NULL,
  `USUARIOid2` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PARTICIPA`
--

CREATE TABLE `PARTICIPA` (
  `USUARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  `cancelado` int(10) DEFAULT NULL,
  `fecha_cancelacion` date DEFAULT NULL,
  `motivos_cancelacion` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `PARTICIPA`
--

INSERT INTO `PARTICIPA` (`USUARIOid`, `ACTIVIDADid`, `fecha_inscripcion`, `cancelado`, `fecha_cancelacion`, `motivos_cancelacion`, `notas`) VALUES
(1, 2, '2025-01-02', 0, NULL, NULL, 'Participante confirmado en el torneo'),
(2, 1, '2025-01-03', 1, '2025-01-04', 'Motivos personales', 'Canceló su inscripción al evento de música');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PATROCINA`
--

CREATE TABLE `PATROCINA` (
  `USUARIOid` bigint(19) NOT NULL,
  `ANUNCIOid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RECIBE`
--

CREATE TABLE `RECIBE` (
  `USUARIOid` bigint(19) NOT NULL,
  `NOTIFICACIONid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ROLES`
--

CREATE TABLE `ROLES` (
  `id` bigint(19) NOT NULL,
  `nombre_rol` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ROLES`
--

INSERT INTO `ROLES` (`id`, `nombre_rol`, `descripcion`) VALUES
(7, 'invitado', 'Cualquier usuario que navega por las partes públicas del portal, sin necesidad de estar registrado o validado en la aplicación.'),
(8, 'registrado', 'Pensado para los usuarios que quieren utilizar la web a la hora de buscar, consultar/visualizar las actividades de su interés, tanto públicas como privadas, gestionar su perfil, gestionar sus avisos, notificaciones y mensajes con moderadores o administradores, gestionar sus propias actividades, las actividades en seguimiento, las actividades como participante, y los comentarios asociados a las actividades.'),
(9, 'moderador', 'Pensado para los usuarios que además deseen colaborar con la web a la hora de moderar las actividades y comentarios de una o varias áreas geográficas.'),
(10, 'patrocinador', 'Pensado para los usuarios que sean patrocinadores y deseen acceder al portal para poder gestionar sus propios anuncios, y sus propias actividades patrocinadas y sus posibles participantes. Estos usuarios se registran de forma especial o son creados previamente por un administrador, dándoles un acceso diferente a la aplicación.'),
(11, 'administrdor_portal', 'Pensado para aquellos usuarios que realizan las tareas de mantenimiento de los datos del sistema, pueden gestionar cualquier cosa de la parte privada como usuarios, actividades y datos asociados, categorías, áreas y ubicaciones, patrocinios, configuración, hacer copias de seguridad o restaurarlas'),
(12, 'administrador_sistema', 'Pensado para los programadores de la aplicación y/o administradores generales del sistema donde se instale, tendrá acceso a todas las funciones de la aplicación sin restricciones, y opcionalmente deberá poder activar el rol que desee para trabajar como un usuario de ese tipo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SIGUE`
--

CREATE TABLE `SIGUE` (
  `USUARIOid` bigint(19) NOT NULL,
  `ACTIVIDADid` bigint(19) NOT NULL,
  `fecha_seguimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `SIGUE`
--

INSERT INTO `SIGUE` (`USUARIOid`, `ACTIVIDADid`, `fecha_seguimiento`) VALUES
(1, 1, '2025-01-01'),
(2, 2, '2025-01-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UBICACION`
--

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

CREATE TABLE `USUARIO` (
  `id` bigint(19) NOT NULL,
  `nick` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `activo` int(10) DEFAULT NULL,
  `fecha_registor` date DEFAULT NULL,
  `registro_confirmado` int(10) DEFAULT NULL,
  `fecha_bloqueo` date DEFAULT NULL,
  `motivo_bloqueo` varchar(255) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`id`, `nick`, `password`, `email`, `nombre`, `apellidos`, `fecha_nacimiento`, `activo`, `fecha_registor`, `registro_confirmado`, `fecha_bloqueo`, `motivo_bloqueo`, `notas`) VALUES
(1, 'user1', 'password123', 'user1@example.com', 'Juan', 'Pérez', '1990-06-15', 1, '2025-01-01', 1, NULL, NULL, 'Activo en el sistema'),
(2, 'user2', 'password456', 'user2@example.com', 'María', 'Gómez', '1985-02-10', 1, '2025-01-02', 1, NULL, NULL, 'Interesado en actividades culturales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_COMENTARIO`
--

CREATE TABLE `USUARIO_COMENTARIO` (
  `COMENTARIOid` bigint(19) NOT NULL,
  `USUARIOid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_HISTORIAL`
--

CREATE TABLE `USUARIO_HISTORIAL` (
  `USUARIOid` bigint(19) NOT NULL,
  `HISTORIALid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_ROLES`
--

CREATE TABLE `USUARIO_ROLES` (
  `USUARIOid` bigint(19) NOT NULL,
  `ROLESid` bigint(19) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO_UBICACION`
--

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
-- Indices de la tabla `CLASIFICACION`
--
ALTER TABLE `CLASIFICACION`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ACTIVIDAD_CLASIFICACION` (`ACTIVIDADid`);

--
-- Indices de la tabla `CLASIFICACION_ACTIVIDAD`
--
ALTER TABLE `CLASIFICACION_ACTIVIDAD`
  ADD PRIMARY KEY (`CLASIFICACIONid`,`ACTIVIDADid`),
  ADD KEY `FKCLASIFICAC873129` (`ACTIVIDADid`);

--
-- Indices de la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
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
-- Indices de la tabla `ESTADO`
--
ALTER TABLE `ESTADO`
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
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ANUNCIO`
--
ALTER TABLE `ANUNCIO`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `CLASIFICACION`
--
ALTER TABLE `CLASIFICACION`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ESTADO`
--
ALTER TABLE `ESTADO`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ETIQUETAS`
--
ALTER TABLE `ETIQUETAS`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `HISTORIAL`
--
ALTER TABLE `HISTORIAL`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `IMAGEN`
--
ALTER TABLE `IMAGEN`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `NOTIFICACION`
--
ALTER TABLE `NOTIFICACION`
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(19) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ACTIVIDAD_UBICACION`
--
ALTER TABLE `ACTIVIDAD_UBICACION`
  ADD CONSTRAINT `FKACTIVIDAD_215592` FOREIGN KEY (`UBICACIONid`) REFERENCES `UBICACION` (`id`),
  ADD CONSTRAINT `FKACTIVIDAD_400498` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `ANUNCIO_ACTIVIDAD`
--
ALTER TABLE `ANUNCIO_ACTIVIDAD`
  ADD CONSTRAINT `FKANUNCIO_AC440486` FOREIGN KEY (`ANUNCIOid`) REFERENCES `ANUNCIO` (`id`),
  ADD CONSTRAINT `FKANUNCIO_AC683805` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `CLASIFICACION`
--
ALTER TABLE `CLASIFICACION`
  ADD CONSTRAINT `ACTIVIDAD_CLASIFICACION` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `CLASIFICACION_ACTIVIDAD`
--
ALTER TABLE `CLASIFICACION_ACTIVIDAD`
  ADD CONSTRAINT `FKCLASIFICAC462280` FOREIGN KEY (`CLASIFICACIONid`) REFERENCES `CLASIFICACION` (`id`),
  ADD CONSTRAINT `FKCLASIFICAC873129` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `COMENTARIO`
--
ALTER TABLE `COMENTARIO`
  ADD CONSTRAINT `ACTIVIDAD_COMENTARIO` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`),
  ADD CONSTRAINT `USUARIO_COMENTARIO` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`);

--
-- Filtros para la tabla `COMENTARIO_ACTIVIDAD`
--
ALTER TABLE `COMENTARIO_ACTIVIDAD`
  ADD CONSTRAINT `FKCOMENTARIO307859` FOREIGN KEY (`COMENTARIOid`) REFERENCES `COMENTARIO` (`id`),
  ADD CONSTRAINT `FKCOMENTARIO875373` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `COMENTARIO_USUARIO`
--
ALTER TABLE `COMENTARIO_USUARIO`
  ADD CONSTRAINT `FKCOMENTARIO192790` FOREIGN KEY (`COMENTARIOid`) REFERENCES `COMENTARIO` (`id`),
  ADD CONSTRAINT `FKCOMENTARIO530790` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`);

--
-- Filtros para la tabla `CREA`
--
ALTER TABLE `CREA`
  ADD CONSTRAINT `FKCREA60709` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKCREA945987` FOREIGN KEY (`NOTIFICACIONid`) REFERENCES `NOTIFICACION` (`id`);

--
-- Filtros para la tabla `ESTADO`
--
ALTER TABLE `ESTADO`
  ADD CONSTRAINT `ACTIVIDAD_ESTADO` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `ESTADO_ACTIVIDAD`
--
ALTER TABLE `ESTADO_ACTIVIDAD`
  ADD CONSTRAINT `FKESTADO_ACT641725` FOREIGN KEY (`ESTADOid`) REFERENCES `ESTADO` (`id`),
  ADD CONSTRAINT `FKESTADO_ACT755533` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `ETIQUETAS_ACTIVIDAD`
--
ALTER TABLE `ETIQUETAS_ACTIVIDAD`
  ADD CONSTRAINT `FKETIQUETAS_587850` FOREIGN KEY (`ETIQUETASid`) REFERENCES `ETIQUETAS` (`id`),
  ADD CONSTRAINT `FKETIQUETAS_815077` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `IMAGEN_ACTIVIDAD`
--
ALTER TABLE `IMAGEN_ACTIVIDAD`
  ADD CONSTRAINT `FKIMAGEN_ACT674560` FOREIGN KEY (`IMAGENid`) REFERENCES `IMAGEN` (`id`),
  ADD CONSTRAINT `FKIMAGEN_ACT974500` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `NOTIFICACION`
--
ALTER TABLE `NOTIFICACION`
  ADD CONSTRAINT `ACTIVIDAD_NOTIFICACION` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

--
-- Filtros para la tabla `PARTICIPA`
--
ALTER TABLE `PARTICIPA`
  ADD CONSTRAINT `FKPARTICIPA262719` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKPARTICIPA722371` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`);

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
  ADD CONSTRAINT `FKSIGUE658643` FOREIGN KEY (`ACTIVIDADid`) REFERENCES `ACTIVIDAD` (`id`),
  ADD CONSTRAINT `FKSIGUE881703` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`);

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
-- Filtros para la tabla `USUARIO_ROLES`
--
ALTER TABLE `USUARIO_ROLES`
  ADD CONSTRAINT `FKUSUARIO_RO928803` FOREIGN KEY (`ROLESid`) REFERENCES `ROLES` (`id`),
  ADD CONSTRAINT `FKUSUARIO_RO976461` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`);

--
-- Filtros para la tabla `USUARIO_UBICACION`
--
ALTER TABLE `USUARIO_UBICACION`
  ADD CONSTRAINT `FKUSUARIO_UB349019` FOREIGN KEY (`USUARIOid`) REFERENCES `USUARIO` (`id`),
  ADD CONSTRAINT `FKUSUARIO_UB925726` FOREIGN KEY (`UBICACIONid`) REFERENCES `UBICACION` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
