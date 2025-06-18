-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2025 a las 14:21:15
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

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`ID_admin`, `Nombre`, `Telefono`, `Email`, `Contraseña`) VALUES
(1, 'admin', 12838132, 'admin@gmail.com', 'Admin1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `ID_carrito` int(11) NOT NULL,
  `ID_producto` int(11) NOT NULL,
  `ID_cliente` int(11) NOT NULL,
  `Estado` enum('pendiente','entregado') NOT NULL DEFAULT 'pendiente',
  `Fecha_cargado` date NOT NULL,
  `Precio_total` decimal(10,2) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Contraseña` varchar(50) NOT NULL CHECK (`Contraseña` regexp cast('^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$' as char charset binary)),
  `Usuario` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`ID_cliente`, `Nombre`, `Apellido`, `Telefono`, `Codigo_postal`, `Localidad`, `Email`, `Contraseña`, `Usuario`) VALUES
(1, 'Fernando', 'Trucolo', 2147483647, 2400, 'San Francisco', 'fernanditotrucolo@gmail.com', 'Hola13254', ''),
(2, 'Claudio', 'Balkenende', 2147483647, 2400, 'San Francisco', 'claudio@gmail.com', 'Claudio123', ''),
(3, 'Fernando', 'roattA', 1234123123, 1231, 'San Francisco', 'fernanditotrucolo@gmail.com', 'Sroa1234', ''),
(4, 'Fernando', 'Trucolo', 2147483647, 2600, 'San Francisco', 'fernanditotrucolo@gmail.com', '1234Aaaa', 'Fer'),
(5, 'Fernando', 'Trucolo', 2147483647, 2600, 'San Francisco', 'fernanditotrucolo@gmail.com', '1234Aaaa', 'Fer');

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
  `Total_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ID_pedido`, `ID_producto`, `ID_cliente`, `Cantidad`, `Medio_pago`, `fecha_pedido`, `Total_venta`) VALUES
(1, 3, 1, 2, 'Tarjeta', '2025-06-17', 7800),
(2, 5, 2, 1, 'Efectivo', '2025-06-15', 3200),
(3, 5, 3, 3, 'Mercado Pago', '2025-06-10', 11250),
(4, 2, 4, 1, 'Tarjeta', '2025-06-12', 4300),
(5, 3, 5, 2, 'Transferencia', '2025-06-16', 6500);

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
(1, 'paquete brasil', '4 estrellas', 10, 20000.00),
(2, 'alojamiento cancun', '4 estrellas', 10, 40000.00),
(3, 'paquete paris', '4 estrellas', 10, 2000000.00),
(4, 'paquete automovil', '4 estrellas', 10, 50000.00),
(5, 'paquete madrid', '4 estrellas', 10, 500000.00);

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
  MODIFY `ID_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `ID_carrito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
