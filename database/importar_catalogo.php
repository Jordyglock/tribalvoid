<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Ejecuta este importador desde la consola de XAMPP.\n");
}

require_once __DIR__ . '/../config/conexion.php';

$directorio = __DIR__ . '/../assets/img/libreria de imagenes productos';
$pdo->exec("CREATE TABLE IF NOT EXISTS imagenes_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    orden SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    UNIQUE KEY uq_producto_imagen (producto_id, imagen),
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
)");

$categorias = [
    'Camisetas' => 85000,
    'Hoodies' => 175000,
    'Chaquetas' => 189000,
    'Pantalones' => 165000,
    'Accesorios' => 59000,
];
$categoriaIds = [];
foreach ($categorias as $nombre => $precio) {
    $st = $pdo->prepare('SELECT id FROM categorias WHERE nombre = ? LIMIT 1');
    $st->execute([$nombre]);
    $id = $st->fetchColumn();
    if (!$id) {
        $pdo->prepare('INSERT INTO categorias (nombre) VALUES (?)')->execute([$nombre]);
        $id = $pdo->lastInsertId();
    }
    $categoriaIds[$nombre] = (int)$id;
}

$archivos = glob($directorio . '/*');
if ($archivos === false || !$archivos) {
    exit("No se encontraron imágenes en: $directorio\n");
}
$grupos = [];
foreach ($archivos as $archivo) {
    if (!is_file($archivo)) continue;
    $nombre = pathinfo($archivo, PATHINFO_FILENAME);
    $base = preg_replace('/\s+(frontal|trasera)$/iu', '', $nombre);
    $base = preg_replace('/\btshir\b/iu', 'tshirt', $base);
    $clave = mb_strtolower($base, 'UTF-8');
    $grupos[$clave]['nombre'] = $base;
    $grupos[$clave]['archivos'][] = basename($archivo);
}

$insertados = 0;
$omitidos = 0;
$pdo->beginTransaction();
try {
    foreach ($grupos as $grupo) {
        $fotos = $grupo['archivos'];
        usort($fotos, static function ($a, $b) {
            $ordenA = stripos($a, 'frontal') === false ? 1 : 0;
            $ordenB = stripos($b, 'frontal') === false ? 1 : 0;
            return ($ordenA <=> $ordenB) ?: strcasecmp($a, $b);
        });

        $nombre = ucwords(str_replace(['-', '_'], ' ', $grupo['nombre']));
        $clave = mb_strtolower($nombre, 'UTF-8');
        if (preg_match('/\b(hoodie|hoddie|sweatshirt)\b/', $clave)) {
            $categoria = 'Hoodies';
        } elseif (preg_match('/\b(jacket|chaqueta)\b/', $clave)) {
            $categoria = 'Chaquetas';
        } elseif (preg_match('/\b(pants|pantalon)\b/', $clave)) {
            $categoria = 'Pantalones';
        } elseif (preg_match('/\b(shirt|tshirt|tshir|blusa|camiseta)\b/', $clave)) {
            $categoria = 'Camisetas';
        } else {
            $categoria = 'Accesorios';
        }

        $primeraFoto = 'libreria de imagenes productos/' . $fotos[0];
        $st = $pdo->prepare('SELECT id FROM productos WHERE nombre = ? LIMIT 1');
        $st->execute([$nombre]);
        $existenteId = (int)$st->fetchColumn();
        if ($existenteId) {
            $insertarFoto = $pdo->prepare('INSERT IGNORE INTO imagenes_producto (producto_id, imagen, orden) VALUES (?,?,?)');
            foreach ($fotos as $orden => $foto) {
                $ruta = 'libreria de imagenes productos/' . $foto;
                $insertarFoto->execute([$existenteId, $ruta, $orden]);
            }
            $imagenActual = $pdo->prepare('SELECT imagen FROM productos WHERE id = ?');
            $imagenActual->execute([$existenteId]);
            if (strpos((string)$imagenActual->fetchColumn(), 'libreria de imagenes productos/') === 0) {
                $pdo->prepare('UPDATE productos SET imagen = ? WHERE id = ?')->execute([$primeraFoto, $existenteId]);
            }
            $omitidos++;
            continue;
        }

        $descripcion = 'Producto de la colección Tribal Void. Revisa las fotos para ver todos los detalles.';
        $pdo->prepare('INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id) VALUES (?,?,?,?,?)')
            ->execute([$nombre, $descripcion, $categorias[$categoria], $primeraFoto, $categoriaIds[$categoria]]);
        $productoId = (int)$pdo->lastInsertId();

        $insertarFoto = $pdo->prepare('INSERT INTO imagenes_producto (producto_id, imagen, orden) VALUES (?,?,?)');
        foreach ($fotos as $orden => $foto) {
            $ruta = 'libreria de imagenes productos/' . $foto;
            $insertarFoto->execute([$productoId, $ruta, $orden]);
        }

        $insertarTalla = $pdo->prepare('INSERT INTO tallas_producto (producto_id, talla, stock) VALUES (?,?,?)');
        if ($categoria === 'Accesorios') {
            $insertarTalla->execute([$productoId, 'Única', 5]);
        } else {
            foreach (['S' => 2, 'M' => 1, 'L' => 1, 'XL' => 1] as $talla => $stock) {
                $insertarTalla->execute([$productoId, $talla, $stock]);
            }
        }
        $insertados++;
    }
    $pdo->commit();
} catch (Throwable $error) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    throw $error;
}

echo "Productos añadidos: $insertados\nProductos omitidos por existir: $omitidos\n";