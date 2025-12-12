-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2025 a las 22:50:55
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gasolina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recargas`
--

CREATE TABLE `recargas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `galones` decimal(10,2) DEFAULT NULL,
  `puntos` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recargas`
--

INSERT INTO `recargas` (`id`, `id_usuario`, `tipo`, `galones`, `puntos`, `fecha`) VALUES
(1, 1030280138, 'gasolina', 1.07, 0, '2025-12-12 14:41:57'),
(2, 11105454, 'gasolina', 1.14, 0, '2025-12-12 14:44:05'),
(3, 11105454, 'gasolina', 1.14, 1, '2025-12-12 14:44:42'),
(4, 11105454, 'gasolina', 1.14, 1, '2025-12-12 14:45:38'),
(5, 11105454, 'gasolina', 1.14, 1, '2025-12-12 14:48:14'),
(6, 11105454, 'gasolina', 1.14, 1, '2025-12-12 14:59:34'),
(7, 11105454, 'gasolina', 1.14, 1, '2025-12-12 15:00:44'),
(8, 11105454, 'gasolina', 1.14, 1, '2025-12-12 15:01:40'),
(9, 11105454, 'gasolina', 1.14, 1, '2025-12-12 15:02:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `roles` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `roles`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` int(11) DEFAULT 2,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `puntos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `telefono`, `password`, `id_rol`, `fecha_registro`, `puntos`) VALUES
(11105454, 'pepito perez', 'cronos23@gmail.com', '3148553944', '$2y$10$s.usKWCtvdD/j1i/up9ps..V1KxX/ynWzvcp91VLKJfU1IecU.hrm', 1, '2025-12-12 18:25:21', 5),
(93406736, 'jaime rico', 'jaimerico54@gmail.com', '3138002510', '$2y$10$ILbjeCFmknvCA1W0BK3zguduMjixTKJI2egPhZUHYIbWXe5nTHMGS', 2, '2025-12-12 21:16:20', 0),
(1030280138, 'luisa sanchez', 'luisasanchez5354@gmail.com', '3115990394', '$2y$10$N2r1EbK33X61VlOwq4llzOe8xJto0A/uftDyuIC77DjUGu0/OJVV2\r\n', 1, '2025-12-12 18:22:19', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recargas`
--
ALTER TABLE `recargas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recargas`
--
ALTER TABLE `recargas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recargas`
--
ALTER TABLE `recargas`
  ADD CONSTRAINT `recargas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
