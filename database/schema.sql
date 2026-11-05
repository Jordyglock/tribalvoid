CREATE DATABASE IF NOT EXISTS marca_dark CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE marca_dark;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS detalle_pedido, pedidos, tallas_producto, imagenes_producto, productos, categorias, mensajes_contacto, datos_contacto, usuarios;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  rol ENUM('cliente','admin') NOT NULL DEFAULT 'cliente',
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(60) NOT NULL
);

CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  descripcion TEXT,
  precio INT NOT NULL,
  imagen VARCHAR(255) DEFAULT NULL,
  categoria_id INT NULL,
  destacado TINYINT(1) NOT NULL DEFAULT 0,
  creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
);

CREATE TABLE imagenes_producto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  orden SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY uq_producto_imagen (producto_id, imagen),
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

CREATE TABLE tallas_producto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  talla VARCHAR(10) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  UNIQUE KEY uq_prod_talla (producto_id, talla),
  FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  total INT NOT NULL,
  estado ENUM('pendiente','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  direccion VARCHAR(200) NOT NULL,
  telefono VARCHAR(30) NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE detalle_pedido (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  talla VARCHAR(10) NOT NULL,
  cantidad INT NOT NULL,
  precio_unitario INT NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE mensajes_contacto (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  email VARCHAR(120) NOT NULL,
  mensaje TEXT NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE datos_contacto (
  id TINYINT UNSIGNED PRIMARY KEY,
  correo VARCHAR(120) NOT NULL DEFAULT '',
  telefono VARCHAR(30) NOT NULL DEFAULT ''
);

INSERT INTO datos_contacto (id, correo, telefono) VALUES (1, '', '');

-- Admin: admintribalvoid@gmail.com / Admin123
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admintribalvoid@gmail.com', '$2y$10$KnoH/5354o94e2kGsegkGuy/RQupP4eNGxwSoD70TryjvNsOh6JlK', 'admin');

INSERT INTO categorias (nombre) VALUES ('Camisetas'), ('Hoodies'), ('Pantalones'), ('Accesorios');

INSERT INTO productos (nombre, descripcion, precio, categoria_id, destacado) VALUES
('Camiseta Hueso Negro', 'Algodón pesado 240 g, estampado neotribal en el pecho y espalda. Corte oversize.', 89000, 1, 1),
('Camiseta Colmillo', 'Estampado en blanco sobre negro lavado. Costuras reforzadas.', 85000, 1, 0),
('Camiseta Raíz Gris', 'Gris carbón con gráfico tribal en la manga. Algodón peruano.', 85000, 1, 1),
('Hoodie Eclipse', 'Capota doble, bolsillo canguro y bordado tribal en la espalda.', 189000, 2, 1),
('Hoodie Ceniza', 'Gris jaspeado, felpa interna, gráfico cosido en el pecho.', 175000, 2, 0),
('Cargo Ritual', 'Pantalón cargo negro con seis bolsillos y correas ajustables.', 165000, 3, 1),
('Gorra Espina', 'Gorra negra de cinco paneles con parche tribal bordado.', 59000, 4, 0),
('Cadena Tótem', 'Cadena de acero con dije tribal. Talla única.', 69000, 4, 0);

INSERT INTO tallas_producto (producto_id, talla, stock)
SELECT p.id, t.talla, 10 FROM productos p
CROSS JOIN (SELECT 'S' AS talla UNION SELECT 'M' UNION SELECT 'L' UNION SELECT 'XL') t
WHERE p.categoria_id <> 4;

INSERT INTO tallas_producto (producto_id, talla, stock)
SELECT id, 'Única', 15 FROM productos WHERE categoria_id = 4;
