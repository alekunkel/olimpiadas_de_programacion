-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2025 a las 00:02:58
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
-- Base de datos: `turismo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `ID_admin` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID_carrito` int(11) NOT NULL,
  `ID_producto` int(11) NOT NULL,
  `ID_cliente` int(11) NOT NULL,
  `Fecha_cargado` date NOT NULL,
  `Precio_total` decimal(10,2) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Estado` varchar(20) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`ID_carrito`, `ID_producto`, `ID_cliente`, `Fecha_cargado`, `Precio_total`, `Cantidad`, `Estado`) VALUES
(2, 2, 3, '2025-06-19', 12999.50, 1, 'pendiente'),
(3, 1, 3, '2025-06-19', 7999.99, 1, 'pendiente'),
(4, 1, 3, '2025-06-19', 7999.99, 1, 'pendiente'),
(5, 1, 3, '2025-06-19', 7999.99, 1, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `ID_cliente` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Apellido` varchar(20) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Codigo_postal` int(10) NOT NULL,
  `Localidad` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Usuario` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_cliente`, `Nombre`, `Apellido`, `Telefono`, `Codigo_postal`, `Localidad`, `Email`, `Contraseña`, `Usuario`) VALUES
(1, 'ale', 'kunkel', 2147483647, 2400, 'San Francisco', 'alejkunkel@gmail.com', '$2y$10$G5zFk9HKhJUcVZkw7ksV.u3l.X3b86GrHcFS7bkiYQj0fb6vsRzUi', 'ale_jk'),
(2, 'Santino', 'Roatta', 2147483647, 2400, 'San Francisco', 'sroatta@escuelasproa.edu.ar', '$2y$10$krMBt4xGGjTrkhanF8eXJ.fg8.AdM0DwQsLw2QRqHKQHHRodfjiJi', 'sroatta'),
(3, 'Franco', 'Ortiz', 2147483647, 2400, 'San Francisco', 'Franco@gmail.com', '$2y$10$256uQvvw7YtoaUl.PLgQAeD0DbdTv/zvryw2xLZAkrnFPRhEpsAge', 'Framco11'),
(4, 'sandra', 'barrionuevo', 2147483647, 2400, 'san francisco cordoba', 'hgdfhgfcv@gmail.com', '$2y$10$ZHPSbC4vda0OjI4t2SyKH.FDcpilheKi.FjUmVc8jtUF9Sm5LWqSO', 'sandri'),
(5, 'Fer', 'Trucolo', 122121221, 2400, 'san francisco', 'fer@gmail.com', '$2y$10$FmUHR/rofiD3YizUSA3Zqum2H.rcrrfxFRCHfx9xZ5Jd/AwRnjHtS', 'fer'),
(6, 'Fer', 'Trucolo', 2147483647, 2400, 'san francisco cordoba', 'fer@gmail.com', '$2y$10$iM3HjhdJ34quHr6ChfUae.mtvHLxL/ljsmxz5l/RuqYqqghbdO5oO', 'fer'),
(7, 'elias', 'trucolo', 2147483647, 2400, 'san francisco cordoba', 'fer@gmail.com', '$2y$10$jB/hwewIHL9PaqvioOEveei69jGW7/38coqbbrVkhI.a4LEw1c1CG', 'elias'),
(8, 'Meli', 'Avila', 2147483647, 2400, 'san francisco cordoba', 'fer@gmail.com', '$2y$10$2dz.VHkx602lXDrR1eYR1Oy.j0g.2HCMXtYHtG1DMfinrXESOlkUm', 'meli'),
(9, 'Fer', 'Trucolo', 123, 22212, 'san francisco cordoba', 'sdasdasda@gsdf', '$2y$10$lXmKMlALxi8Ksod3nCVsM.8OM0.Se8UcHqf1Oe0atdnkHUWImD.sG', 'fer'),
(10, 'Emilio', 'Lodi', 2147483647, 2400, 'San Francisco, Cordoba, Argentina', 'elodi@escuelasproa.edu.ar', '$2y$10$2/909rnBQLMxpRTST7fb6OKPfW0LFsAqWGrxrCV6xGbUQ.4DV.zW6', 'elodi57'),
(11, 'Federico', 'Francia', 2147483647, 2400, 'San Francisco', 'ffrancia@escuelasproa.edu.ar', '$2y$10$62fiT1qZzzW.RdAdi8WPy.jihnP68bsfRteCrFibb9N4UNgFr52TK', 'ffrancia'),
(12, 'Martina', 'Kunkel', 356496969, 2400, 'San Francisco, Cordoba, Argentina', 'martu@gmail.com', '$2y$10$9cW0guEQyBIpV5SyG72UMOl4/cm088mqjwI5jieP2CZhpyLqRGSpq', 'Marta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID_pedido` int(11) NOT NULL,
  `ID_producto` int(11) NOT NULL,
  `ID_cliente` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Medio_pago` varchar(30) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `Total_venta` int(11) NOT NULL,
  `Estado` varchar(20) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ID_pedido`, `ID_producto`, `ID_cliente`, `Cantidad`, `Medio_pago`, `fecha_pedido`, `Total_venta`, `Estado`) VALUES
(1, 1, 5, 1, 'MP', '2025-06-22', 8000, 'entregado'),
(2, 2, 5, 1, 'MP', '2025-06-22', 13000, 'cancelado'),
(3, 6, 5, 1, 'MP', '2025-06-22', 500000, 'entregado'),
(4, 6, 5, 1, 'MP', '2025-06-22', 500000, 'entregado'),
(5, 1, 5, 1, 'MP', '2025-06-22', 8000, 'entregado'),
(6, 5, 5, 1, 'naranja', '2025-06-22', 38000, 'entregado'),
(7, 6, 5, 1, 'naranja', '2025-06-22', 500000, 'entregado'),
(8, 6, 7, 1, 'naranja', '2025-06-22', 500000, 'cancelado'),
(9, 1, 8, 1, 'MP', '2025-06-23', 8000, 'entregado'),
(10, 3, 10, 1, 'MP', '2025-06-23', 500000, 'entregado'),
(11, 1, 10, 1, 'MP', '2025-06-23', 203000, 'cancelado'),
(12, 2, 11, 1, 'MP', '2025-06-23', 13000, 'entregado'),
(13, 3, 5, 1, 'tarjeta', '2025-06-23', 6599, 'entregado'),
(14, 3, 5, 1, 'tarjeta', '2025-06-23', 500000, 'entregado'),
(15, 4, 5, 1, 'tarjeta', '2025-06-23', 46000, 'entregado'),
(16, 6, 12, 1, 'naranja', '2025-06-23', 500000, 'Pendiente'),
(17, 2, 12, 1, 'MP', '2025-06-23', 13000, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_producto` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Calificacion` varchar(50) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_producto`, `Nombre`, `Calificacion`, `Cantidad`, `Precio`) VALUES
(1, 'Hotel paris', '4', 47, 203000.00),
(2, 'Teclado Mecánico RGB', '4.8', 12, 12999.50),
(3, 'Hotel Madrid', '3', 88, 500000.00),
(4, 'Monitor LED 24 pulgadas', '4.7', 9, 45999.90),
(5, 'Silla Ergonómica Oficina', '4.6', 0, 37999.99),
(6, 'Hotel Miami', '4 estrellas', 25, 500000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ID_admin`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`ID_carrito`),
  ADD KEY `ID_producto` (`ID_producto`),
  ADD KEY `ID_cliente` (`ID_cliente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID_cliente`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID_pedido`),
  ADD KEY `ID_producto` (`ID_producto`),
  ADD KEY `ID_cliente` (`ID_cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ID_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`ID_producto`) REFERENCES `productos` (`ID_producto`),
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`ID_cliente`) REFERENCES `cliente` (`ID_cliente`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ID_producto`) REFERENCES `productos` (`ID_producto`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`ID_cliente`) REFERENCES `cliente` (`ID_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
