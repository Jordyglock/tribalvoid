-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2026 a las 22:56:56
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
-- Base de datos: `marca_dark`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Camisetas'),
(2, 'Hoodies'),
(3, 'Pantalones'),
(4, 'Accesorios'),
(5, 'Chaquetas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_contacto`
--

CREATE TABLE `datos_contacto` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `correo` varchar(120) NOT NULL DEFAULT '',
  `telefono` varchar(30) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `datos_contacto`
--

INSERT INTO `datos_contacto` (`id`, `correo`, `telefono`) VALUES
(1, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_producto`
--

CREATE TABLE `imagenes_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `orden` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagenes_producto`
--

INSERT INTO `imagenes_producto` (`id`, `producto_id`, `imagen`, `orden`) VALUES
(1, 9, 'libreria de imagenes productos/3pack-pipas kitty.jpg', 0),
(2, 10, 'libreria de imagenes productos/alien glasses.jpeg', 0),
(3, 11, 'libreria de imagenes productos/anillos 3pack-brillibrilli.jpg', 0),
(4, 12, 'libreria de imagenes productos/bettyboop blusa frontal.png', 0),
(5, 12, 'libreria de imagenes productos/bettyboop blusa trasera.png', 1),
(6, 13, 'libreria de imagenes productos/bichi guantes.jpeg', 0),
(7, 14, 'libreria de imagenes productos/blusa diablito frontal.png', 0),
(8, 14, 'libreria de imagenes productos/blusa diablito trasera.png', 1),
(9, 15, 'libreria de imagenes productos/blusa kirk frontal.png', 0),
(10, 15, 'libreria de imagenes productos/blusa kirk trasera.png', 1),
(11, 16, 'libreria de imagenes productos/blusa yandere blanca frontal.png', 0),
(12, 16, 'libreria de imagenes productos/blusa yandere blanca trasera.png', 1),
(13, 17, 'libreria de imagenes productos/blusa yandere negra frontal.png', 0),
(14, 17, 'libreria de imagenes productos/blusa yandere negra trasera.png', 1),
(15, 18, 'libreria de imagenes productos/bong doo.jpg', 0),
(16, 19, 'libreria de imagenes productos/bong face.jpeg', 0),
(17, 20, 'libreria de imagenes productos/brico china cochina.jpg', 0),
(18, 21, 'libreria de imagenes productos/brico jenner.jpeg', 0),
(19, 22, 'libreria de imagenes productos/bricoballo.jpeg', 0),
(20, 23, 'libreria de imagenes productos/buda\'s jokes tshirt frontal.png', 0),
(21, 23, 'libreria de imagenes productos/buda\'s jokes tshirt trasera.png', 1),
(22, 24, 'libreria de imagenes productos/bunny-fanda.jpeg', 0),
(23, 25, 'libreria de imagenes productos/colita de mapache.jpeg', 0),
(24, 26, 'libreria de imagenes productos/ero-doll-mask.jpeg', 0),
(25, 27, 'libreria de imagenes productos/eye-bag.jpeg', 0),
(26, 28, 'libreria de imagenes productos/fat tigger pin.jpg', 0),
(27, 29, 'libreria de imagenes productos/flotershy hoodie.jpg', 0),
(28, 30, 'libreria de imagenes productos/godines gun tshirt.jpeg', 0),
(29, 31, 'libreria de imagenes productos/gorra rosa-cruz- brillibrilli.jpg', 0),
(30, 32, 'libreria de imagenes productos/gorro esponja.jpeg', 0),
(31, 33, 'libreria de imagenes productos/helicopter paracopter hat.jpeg', 0),
(32, 34, 'libreria de imagenes productos/jacket acido frontal.png', 0),
(33, 34, 'libreria de imagenes productos/jacket acido trasera.png', 1),
(34, 35, 'libreria de imagenes productos/kat-bag.jpeg', 0),
(35, 36, 'libreria de imagenes productos/kat-pack.jpg', 0),
(36, 37, 'libreria de imagenes productos/leopard asian cap.jpeg', 0),
(37, 38, 'libreria de imagenes productos/love hoodie frontal.png', 0),
(38, 38, 'libreria de imagenes productos/love hoodie trasera.png', 1),
(39, 39, 'libreria de imagenes productos/malboro case audifonos.jpeg', 0),
(40, 40, 'libreria de imagenes productos/monster-pants.jpeg', 0),
(41, 41, 'libreria de imagenes productos/navajas kitty.jpg', 0),
(42, 42, 'libreria de imagenes productos/polar-flower-cap.jpeg', 0),
(43, 43, 'libreria de imagenes productos/rare face tshirt frontal.png', 0),
(44, 43, 'libreria de imagenes productos/rare face tshirt trasera.png', 1),
(45, 44, 'libreria de imagenes productos/rasca kitty.jpeg', 0),
(46, 45, 'libreria de imagenes productos/rolenlo pin.jpg', 0),
(47, 46, 'libreria de imagenes productos/rose bettyboop tshirt frontal.png', 0),
(48, 46, 'libreria de imagenes productos/rose bettyboop tshirt trasera.png', 1),
(49, 47, 'libreria de imagenes productos/rose-emoji-hoddie.jpeg', 0),
(50, 48, 'libreria de imagenes productos/rose-jacket.jpeg', 0),
(51, 49, 'libreria de imagenes productos/rose-walter-cap.jpeg', 0),
(52, 50, 'libreria de imagenes productos/sado-bear.mask-bong.jpeg', 0),
(53, 51, 'libreria de imagenes productos/sex-net-core-hoddie.jpeg', 0),
(54, 52, 'libreria de imagenes productos/spongebob-pack.jpeg', 0),
(55, 53, 'libreria de imagenes productos/surtido de gorros weirdos.jpeg', 0),
(56, 54, 'libreria de imagenes productos/tshirt cuadro de acido frontal.png', 0),
(57, 54, 'libreria de imagenes productos/tshirt cuadro de acido trasera.png', 1),
(58, 55, 'libreria de imagenes productos/tshirt diablito frontal.png', 0),
(59, 55, 'libreria de imagenes productos/tshirt diablito trasera.png', 1),
(60, 56, 'libreria de imagenes productos/tshirt kirk frontal.png', 0),
(61, 56, 'libreria de imagenes productos/tshirt kirk trasera.png', 1),
(63, 58, 'libreria de imagenes productos/yandere tshirt blanca frontal.png', 0),
(64, 58, 'libreria de imagenes productos/yandere tshirt blanca trasera.png', 1),
(65, 59, 'libreria de imagenes productos/yandere tshirt negra trasera.png', 0),
(66, 60, 'libreria de imagenes productos/yellow eyes cap.jpg', 0),
(128, 59, 'libreria de imagenes productos/yandere tshir negra frontal.png', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `email` varchar(120) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `estado` enum('pendiente','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `creado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria_id`, `destacado`, `creado`) VALUES
(1, 'Camiseta Hueso Negro', 'Algodón pesado 240 g, estampado neotribal en el pecho y espalda. Corte oversize.', 89000, NULL, 1, 1, '2026-11-02 23:24:20'),
(2, 'Camiseta Colmillo', 'Estampado en blanco sobre negro lavado. Costuras reforzadas.', 85000, NULL, 1, 0, '2026-11-02 23:24:20'),
(3, 'Camiseta Raíz Gris', 'Gris carbón con gráfico tribal en la manga. Algodón peruano.', 85000, NULL, 1, 1, '2026-11-02 23:24:20'),
(4, 'Hoodie Eclipse', 'Capota doble, bolsillo canguro y bordado tribal en la espalda.', 189000, NULL, 2, 1, '2026-11-02 23:24:20'),
(5, 'Hoodie Ceniza', 'Gris jaspeado, felpa interna, gráfico cosido en el pecho.', 175000, NULL, 2, 0, '2026-11-02 23:24:20'),
(6, 'Cargo Ritual', 'Pantalón cargo negro con seis bolsillos y correas ajustables.', 165000, NULL, 3, 1, '2026-11-02 23:24:20'),
(7, 'Gorra Espina', 'Gorra negra de cinco paneles con parche tribal bordado.', 59000, NULL, 4, 0, '2026-11-02 23:24:20'),
(8, 'Cadena Tótem', 'Cadena de acero con dije tribal. Talla única.', 69000, NULL, 4, 0, '2026-11-02 23:24:20'),
(9, '3pack Pipas Kitty', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/3pack-pipas kitty.jpg', 4, 0, '2026-11-02 23:53:39'),
(10, 'Alien Glasses', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/alien glasses.jpeg', 4, 0, '2026-11-02 23:53:39'),
(11, 'Anillos 3pack Brillibrilli', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/anillos 3pack-brillibrilli.jpg', 4, 0, '2026-11-02 23:53:39'),
(12, 'Bettyboop Blusa', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/bettyboop blusa frontal.png', 1, 0, '2026-11-02 23:53:39'),
(13, 'Bichi Guantes', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/bichi guantes.jpeg', 4, 0, '2026-11-02 23:53:39'),
(14, 'Blusa Diablito', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/blusa diablito frontal.png', 1, 0, '2026-11-02 23:53:39'),
(15, 'Blusa Kirk', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/blusa kirk frontal.png', 1, 0, '2026-11-02 23:53:39'),
(16, 'Blusa Yandere Blanca', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/blusa yandere blanca frontal.png', 1, 0, '2026-11-02 23:53:39'),
(17, 'Blusa Yandere Negra', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/blusa yandere negra frontal.png', 1, 0, '2026-11-02 23:53:39'),
(18, 'Bong Doo', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/bong doo.jpg', 4, 0, '2026-11-02 23:53:39'),
(19, 'Bong Face', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/bong face.jpeg', 4, 0, '2026-11-02 23:53:39'),
(20, 'Brico China Cochina', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/brico china cochina.jpg', 4, 0, '2026-11-02 23:53:39'),
(21, 'Brico Jenner', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/brico jenner.jpeg', 4, 0, '2026-11-02 23:53:39'),
(22, 'Bricoballo', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/bricoballo.jpeg', 4, 0, '2026-11-02 23:53:39'),
(23, 'Buda\'s Jokes Tshirt', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/buda\'s jokes tshirt frontal.png', 1, 0, '2026-11-02 23:53:39'),
(24, 'Bunny Fanda', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/bunny-fanda.jpeg', 4, 0, '2026-11-02 23:53:39'),
(25, 'Colita De Mapache', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/colita de mapache.jpeg', 4, 0, '2026-11-02 23:53:39'),
(26, 'Ero Doll Mask', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/ero-doll-mask.jpeg', 4, 0, '2026-11-02 23:53:39'),
(27, 'Eye Bag', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/eye-bag.jpeg', 4, 0, '2026-11-02 23:53:39'),
(28, 'Fat Tigger Pin', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/fat tigger pin.jpg', 4, 0, '2026-11-02 23:53:39'),
(29, 'Flotershy Hoodie', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 175000, 'libreria de imagenes productos/flotershy hoodie.jpg', 2, 0, '2026-11-02 23:53:39'),
(30, 'Godines Gun Tshirt', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/godines gun tshirt.jpeg', 1, 0, '2026-11-02 23:53:39'),
(31, 'Gorra Rosa Cruz  Brillibrilli', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/gorra rosa-cruz- brillibrilli.jpg', 4, 0, '2026-11-02 23:53:39'),
(32, 'Gorro Esponja', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/gorro esponja.jpeg', 4, 0, '2026-11-02 23:53:39'),
(33, 'Helicopter Paracopter Hat', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/helicopter paracopter hat.jpeg', 4, 0, '2026-11-02 23:53:39'),
(34, 'Jacket Acido', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 189000, 'libreria de imagenes productos/jacket acido frontal.png', 5, 0, '2026-11-02 23:53:39'),
(35, 'Kat Bag', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/kat-bag.jpeg', 4, 0, '2026-11-02 23:53:39'),
(36, 'Kat Pack', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/kat-pack.jpg', 4, 0, '2026-11-02 23:53:39'),
(37, 'Leopard Asian Cap', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/leopard asian cap.jpeg', 4, 0, '2026-11-02 23:53:39'),
(38, 'Love Hoodie', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 175000, 'libreria de imagenes productos/love hoodie frontal.png', 2, 0, '2026-11-02 23:53:39'),
(39, 'Malboro Case Audifonos', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/malboro case audifonos.jpeg', 4, 0, '2026-11-02 23:53:39'),
(40, 'Monster Pants', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 165000, 'libreria de imagenes productos/monster-pants.jpeg', 3, 0, '2026-11-02 23:53:39'),
(41, 'Navajas Kitty', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/navajas kitty.jpg', 4, 0, '2026-11-02 23:53:39'),
(42, 'Polar Flower Cap', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/polar-flower-cap.jpeg', 4, 0, '2026-11-02 23:53:39'),
(43, 'Rare Face Tshirt', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/rare face tshirt frontal.png', 1, 0, '2026-11-02 23:53:39'),
(44, 'Rasca Kitty', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/rasca kitty.jpeg', 4, 0, '2026-11-02 23:53:39'),
(45, 'Rolenlo Pin', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/rolenlo pin.jpg', 4, 0, '2026-11-02 23:53:39'),
(46, 'Rose Bettyboop Tshirt', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/rose bettyboop tshirt frontal.png', 1, 0, '2026-11-02 23:53:39'),
(47, 'Rose Emoji Hoddie', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 175000, 'libreria de imagenes productos/rose-emoji-hoddie.jpeg', 2, 0, '2026-11-02 23:53:39'),
(48, 'Rose Jacket', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 189000, 'libreria de imagenes productos/rose-jacket.jpeg', 5, 0, '2026-11-02 23:53:39'),
(49, 'Rose Walter Cap', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/rose-walter-cap.jpeg', 4, 0, '2026-11-02 23:53:39'),
(50, 'Sado Bear.mask Bong', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/sado-bear.mask-bong.jpeg', 4, 0, '2026-11-02 23:53:39'),
(51, 'Sex Net Core Hoddie', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 175000, 'libreria de imagenes productos/sex-net-core-hoddie.jpeg', 2, 0, '2026-11-02 23:53:39'),
(52, 'Spongebob Pack', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/spongebob-pack.jpeg', 4, 0, '2026-11-02 23:53:39'),
(53, 'Surtido De Gorros Weirdos', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/surtido de gorros weirdos.jpeg', 4, 0, '2026-11-02 23:53:39'),
(54, 'Tshirt Cuadro De Acido', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/tshirt cuadro de acido frontal.png', 1, 0, '2026-11-02 23:53:39'),
(55, 'Tshirt Diablito', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/tshirt diablito frontal.png', 1, 0, '2026-11-02 23:53:39'),
(56, 'Tshirt Kirk', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/tshirt kirk frontal.png', 1, 0, '2026-11-02 23:53:39'),
(58, 'Yandere Tshirt Blanca', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/yandere tshirt blanca frontal.png', 1, 0, '2026-11-02 23:53:39'),
(59, 'Yandere Tshirt Negra', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 85000, 'libreria de imagenes productos/yandere tshir negra frontal.png', 1, 0, '2026-11-02 23:53:39'),
(60, 'Yellow Eyes Cap', 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.', 59000, 'libreria de imagenes productos/yellow eyes cap.jpg', 4, 0, '2026-11-02 23:53:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas_producto`
--

CREATE TABLE `tallas_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tallas_producto`
--

INSERT INTO `tallas_producto` (`id`, `producto_id`, `talla`, `stock`) VALUES
(1, 1, 'S', 10),
(2, 1, 'M', 10),
(3, 1, 'L', 10),
(4, 1, 'XL', 10),
(5, 2, 'S', 10),
(6, 2, 'M', 10),
(7, 2, 'L', 10),
(8, 2, 'XL', 10),
(9, 3, 'S', 10),
(10, 3, 'M', 10),
(11, 3, 'L', 10),
(12, 3, 'XL', 10),
(13, 4, 'S', 10),
(14, 4, 'M', 10),
(15, 4, 'L', 10),
(16, 4, 'XL', 10),
(17, 5, 'S', 10),
(18, 5, 'M', 10),
(19, 5, 'L', 10),
(20, 5, 'XL', 10),
(21, 6, 'S', 10),
(22, 6, 'M', 10),
(23, 6, 'L', 10),
(24, 6, 'XL', 10),
(32, 7, 'Única', 15),
(33, 8, 'Única', 15),
(35, 9, 'Única', 5),
(36, 10, 'Única', 5),
(37, 11, 'Única', 5),
(38, 12, 'S', 2),
(39, 12, 'M', 1),
(40, 12, 'L', 1),
(41, 12, 'XL', 1),
(42, 13, 'Única', 5),
(43, 14, 'S', 2),
(44, 14, 'M', 1),
(45, 14, 'L', 1),
(46, 14, 'XL', 1),
(47, 15, 'S', 2),
(48, 15, 'M', 1),
(49, 15, 'L', 1),
(50, 15, 'XL', 1),
(51, 16, 'S', 2),
(52, 16, 'M', 1),
(53, 16, 'L', 1),
(54, 16, 'XL', 1),
(55, 17, 'S', 2),
(56, 17, 'M', 1),
(57, 17, 'L', 1),
(58, 17, 'XL', 1),
(59, 18, 'Única', 5),
(60, 19, 'Única', 5),
(61, 20, 'Única', 5),
(62, 21, 'Única', 5),
(63, 22, 'Única', 5),
(64, 23, 'S', 2),
(65, 23, 'M', 1),
(66, 23, 'L', 1),
(67, 23, 'XL', 1),
(68, 24, 'Única', 5),
(69, 25, 'Única', 5),
(70, 26, 'Única', 5),
(71, 27, 'Única', 5),
(72, 28, 'Única', 5),
(73, 29, 'S', 2),
(74, 29, 'M', 1),
(75, 29, 'L', 1),
(76, 29, 'XL', 1),
(77, 30, 'S', 2),
(78, 30, 'M', 1),
(79, 30, 'L', 1),
(80, 30, 'XL', 1),
(81, 31, 'Única', 5),
(82, 32, 'Única', 5),
(83, 33, 'Única', 5),
(84, 34, 'S', 2),
(85, 34, 'M', 1),
(86, 34, 'L', 1),
(87, 34, 'XL', 1),
(88, 35, 'Única', 5),
(89, 36, 'Única', 5),
(90, 37, 'Única', 5),
(91, 38, 'S', 2),
(92, 38, 'M', 1),
(93, 38, 'L', 1),
(94, 38, 'XL', 1),
(95, 39, 'Única', 5),
(96, 40, 'S', 2),
(97, 40, 'M', 1),
(98, 40, 'L', 1),
(99, 40, 'XL', 1),
(100, 41, 'Única', 5),
(101, 42, 'Única', 5),
(102, 43, 'S', 2),
(103, 43, 'M', 1),
(104, 43, 'L', 1),
(105, 43, 'XL', 1),
(106, 44, 'Única', 5),
(107, 45, 'Única', 5),
(108, 46, 'S', 2),
(109, 46, 'M', 1),
(110, 46, 'L', 1),
(111, 46, 'XL', 1),
(112, 47, 'S', 2),
(113, 47, 'M', 1),
(114, 47, 'L', 1),
(115, 47, 'XL', 1),
(116, 48, 'S', 2),
(117, 48, 'M', 1),
(118, 48, 'L', 1),
(119, 48, 'XL', 1),
(120, 49, 'Única', 5),
(121, 50, 'Única', 5),
(122, 51, 'S', 2),
(123, 51, 'M', 1),
(124, 51, 'L', 1),
(125, 51, 'XL', 1),
(126, 52, 'Única', 5),
(127, 53, 'Única', 5),
(128, 54, 'S', 2),
(129, 54, 'M', 1),
(130, 54, 'L', 1),
(131, 54, 'XL', 1),
(132, 55, 'S', 2),
(133, 55, 'M', 1),
(134, 55, 'L', 1),
(135, 55, 'XL', 1),
(136, 56, 'S', 2),
(137, 56, 'M', 1),
(138, 56, 'L', 1),
(139, 56, 'XL', 1),
(144, 58, 'S', 2),
(145, 58, 'M', 1),
(146, 58, 'L', 1),
(147, 58, 'XL', 1),
(148, 59, 'S', 2),
(149, 59, 'M', 1),
(150, 59, 'L', 1),
(151, 59, 'XL', 1),
(152, 60, 'Única', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('cliente','admin') NOT NULL DEFAULT 'cliente',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Administrador', 'admintribalvoid@gmail.com', '$2y$10$KnoH/5354o94e2kGsegkGuy/RQupP4eNGxwSoD70TryjvNsOh6JlK', 'admin', '2026-11-02 23:24:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datos_contacto`
--
ALTER TABLE `datos_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_producto_imagen` (`producto_id`,`imagen`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `tallas_producto`
--
ALTER TABLE `tallas_producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_prod_talla` (`producto_id`,`talla`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `tallas_producto`
--
ALTER TABLE `tallas_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `imagenes_producto`
--
ALTER TABLE `imagenes_producto`
  ADD CONSTRAINT `imagenes_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `tallas_producto`
--
ALTER TABLE `tallas_producto`
  ADD CONSTRAINT `tallas_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
