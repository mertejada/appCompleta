-- NO SÉ SI ES CORRECTO, ES LA EXPORTACIÓN DE LA BD QUE HE HECHO EN PHPMYADMIN


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Base de datos: `Nebula`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `CodCat` int(11) NOT NULL,
  `NomCat` varchar(40) NOT NULL,
  `DescripcionCat` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`CodCat`, `NomCat`, `DescripcionCat`) VALUES
(1, 'Ordenadores', 'Portátiles y sobremesa'),
(2, 'Móviles', 'Dispositivos móviles'),
(3, 'Tablets', 'Tablets pequeñas y medianas'),
(4, 'Auriculares', 'Inalámbricos, con cable, acuáticos, etc.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `CodPedido` int(11) NOT NULL,
  `Enviado` tinyint(1) NOT NULL DEFAULT 0,
  `Recibido` tinyint(1) NOT NULL DEFAULT 0,
  `IdUsuario` varchar(15) NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidosproductos`
--

CREATE TABLE `pedidosproductos` (
  `CodPedidoProducto` int(11) NOT NULL,
  `CodProd` int(11) NOT NULL,
  `CodPedido` int(11) NOT NULL,
  `Unidades` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `CodProd` int(11) NOT NULL,
  `NomProd` varchar(40) NOT NULL,
  `DescripcionProd` varchar(120) NOT NULL,
  `Stock` int(11) NOT NULL,
  `PrecioProd` float(11,2) NOT NULL,
  `PesoProd` float(11,2) NOT NULL,
  `CodCat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`CodProd`, `NomProd`, `DescripcionProd`, `Stock`, `PrecioProd`, `PesoProd`, `CodCat`) VALUES
(1, 'HP Victus 15L TG02-0049ns', 'PC Intel® Core™ i5-12400F, 16GB RAM, 512GB Plata', 3, 1149.90, 2.00, 1),
(2, 'Portátil LG 16ZB90R-G.AA75B', '16\" WQXGA, Intel® Evo™ Core™ i7-1360P, 16GB RAM, 512 GB SSD, Windows 11 Home, Negro', 0, 1119.50, 1.00, 1),
(3, 'iPhone 15', '128GB | White', 5, 992.00, 0.40, 2),
(4, 'Samsung Galaxy Tab A8', '128 GB eMMC, Gris Oscuro', 5, 219.00, 0.70, 3),
(5, 'Sony WH-1000XM4B', 'Cancelación ruido (Noise Cancelling), 30h', 5, 199.00, 0.30, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` varchar(15) NOT NULL,
  `NombreUsuario` varchar(80) NOT NULL,
  `ApellidoUsuario` varchar(80) NOT NULL,
  `Clave` varchar(255) NOT NULL,
  `CodRol` tinyint(1) NOT NULL DEFAULT 0,
  `DescripcionRol` varchar(20) NOT NULL DEFAULT 'Cliente',
  `Correo` varchar(40) NOT NULL,
  `FechaNac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `NombreUsuario`, `ApellidoUsuario`, `Clave`, `CodRol`, `DescripcionRol`, `Correo`, `FechaNac`) VALUES
('a', 'a', 'a', '$2y$04$M.k4GpmqQ59haqPuJjUqT.TFwogub3Et7Dt2SymnxXhtb0M0FhH.q', 0, 'Cliente', 'mer@gmail.com', '1950-01-01'),
('admin', 'Mercedes', 'Tejada', '$2y$04$d/gTpOWxgFIUqJ60SVS3OeHsw6z4vR5RpHykwEa8Q4RXTTN5SCRXK', 1, 'Admin', 'mercedestejadaporcel@gmail.com', '2002-08-07');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`CodCat`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`CodPedido`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `pedidosproductos`
--
ALTER TABLE `pedidosproductos`
  ADD PRIMARY KEY (`CodPedidoProducto`),
  ADD KEY `CodProd` (`CodProd`),
  ADD KEY `pedidosproductos_ibfk_2` (`CodPedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`CodProd`),
  ADD KEY `CodCat` (`CodCat`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `CodCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `CodPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidosproductos`
--
ALTER TABLE `pedidosproductos`
  MODIFY `CodPedidoProducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `CodProd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`IdUsuario`);

--
-- Filtros para la tabla `pedidosproductos`
--
ALTER TABLE `pedidosproductos`
  ADD CONSTRAINT `pedidosproductos_ibfk_1` FOREIGN KEY (`CodProd`) REFERENCES `productos` (`CodProd`),
  ADD CONSTRAINT `pedidosproductos_ibfk_2` FOREIGN KEY (`CodPedido`) REFERENCES `pedidos` (`CodPedido`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`CodCat`) REFERENCES `categorias` (`codCat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;