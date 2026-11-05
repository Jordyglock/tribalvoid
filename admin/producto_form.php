<?php
require_once '../config/conexion.php';
requiereAdmin();
$TALLAS = ['S', 'M', 'L', 'XL', 'Única'];
$id = (int)($_GET['id'] ?? 0);
$p = ['nombre' => '', 'descripcion' => '', 'precio' => '', 'categoria_id' => '', 'destacado' => 0, 'imagen' => null];
$stock = array_fill_keys($TALLAS, 0);
if ($id) {
    $st = $pdo->prepare("SELECT * FROM productos WHERE id = ?"); $st->execute([$id]);
    $p = $st->fetch() ?: exit('Producto no existe');
    $st = $pdo->prepare("SELECT talla, stock FROM tallas_producto WHERE producto_id = ?"); $st->execute([$id]);
    foreach ($st->fetchAll() as $r) $stock[$r['talla']] = (int)$r['stock'];
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? ''); $desc = trim($_POST['descripcion'] ?? '');
    $precio = (int)($_POST['precio'] ?? 0); $cat = (int)($_POST['categoria_id'] ?? 0) ?: null;
    $dest = isset($_POST['destacado']) ? 1 : 0;
    $imagen = $p['imagen'];

    if ($nombre === '' || $precio <= 0) $error = 'Escribe un nombre y un precio mayor a 0.';
    if (!$error && !empty($_FILES['imagen']['name'])) {
        $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) || $_FILES['imagen']['size'] > 3 * 1024 * 1024) {
            $error = 'La imagen debe ser JPG, PNG o WEBP y pesar menos de 3 MB.';
        } else {
            $imagen = uniqid('p_') . '.' . $ext;
            move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . '/../assets/img/productos/' . $imagen);
        }
    }
    if (!$error) {
        if ($id) {
            $pdo->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, categoria_id=?, destacado=?, imagen=? WHERE id=?")
                ->execute([$nombre, $desc, $precio, $cat, $dest, $imagen, $id]);
        } else {
            $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria_id, destacado, imagen) VALUES (?,?,?,?,?,?)")
                ->execute([$nombre, $desc, $precio, $cat, $dest, $imagen]);
            $id = (int)$pdo->lastInsertId();
        }
        foreach ($TALLAS as $t) {
            $pdo->prepare("INSERT INTO tallas_producto (producto_id, talla, stock) VALUES (?,?,?) ON DUPLICATE KEY UPDATE stock = VALUES(stock)")
                ->execute([$id, $t, max(0, (int)($_POST['stock'][$t] ?? 0))]);
        }
        header('Location: productos.php'); exit;
    }
    $p = array_merge($p, ['nombre' => $nombre, 'descripcion' => $desc, 'precio' => $precio, 'categoria_id' => $cat, 'destacado' => $dest]);
}
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll();
$titulo = $id ? 'Editar producto' : 'Nuevo producto';
include '../includes/header.php';
include '../includes/admin_nav.php';
?>
<section class="seccion angosta">
    <h2><?= e($titulo) ?></h2>
    <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="form">
        <label class="campo">Nombre <input type="text" name="nombre" required value="<?= e($p['nombre']) ?>"></label>
        <label class="campo">Descripción <textarea name="descripcion"><?= e($p['descripcion']) ?></textarea></label>
        <label class="campo">Precio (COP) <input type="number" name="precio" min="1" required value="<?= e($p['precio']) ?>"></label>
        <label class="campo">Categoría
            <select name="categoria_id">
                <option value="">Sin categoría</option>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= (int)$p['categoria_id'] === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="campo">Foto (JPG, PNG o WEBP) <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp"></label>
        <?php if ($p['imagen']): ?><img src="<?= imgProducto($p['imagen']) ?>" alt="" style="width:120px"><?php endif; ?>
        <div>
            <p class="lead">Stock por talla (usa "Única" para accesorios)</p>
            <div class="tallas-admin">
                <?php foreach ($TALLAS as $t): ?>
                    <label class="campo"><?= e($t) ?> <input type="number" name="stock[<?= e($t) ?>]" min="0" value="<?= $stock[$t] ?>"></label>
                <?php endforeach; ?>
            </div>
        </div>
        <label class="check"><input type="checkbox" name="destacado" <?= $p['destacado'] ? 'checked' : '' ?>> Mostrar en el inicio</label>
        <button class="btn" type="submit">Guardar producto</button>
    </form>
</section>
<?php include '../includes/footer.php'; ?>
