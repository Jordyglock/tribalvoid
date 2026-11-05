<?php
require_once '../config/conexion.php';
requiereAdmin();
$titulo = 'Panel';
$n = fn($t) => (int)$pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn();
$ventas = (int)$pdo->query("SELECT COALESCE(SUM(total),0) FROM pedidos WHERE estado <> 'cancelado'")->fetchColumn();
$msgs = $pdo->query("SELECT * FROM mensajes_contacto ORDER BY id DESC LIMIT 10")->fetchAll();
$productos = $pdo->query("SELECT p.id, p.nombre, p.precio, c.nombre AS categoria,
    (SELECT COALESCE(SUM(stock),0) FROM tallas_producto WHERE producto_id = p.id) AS stock
    FROM productos p LEFT JOIN categorias c ON c.id = p.categoria_id
    ORDER BY p.id DESC")->fetchAll();
include '../includes/header.php';
include '../includes/admin_nav.php';
?>
<section class="seccion medio">
    <h2>Administrador</h2>
    <div class="stats">
        <div class="stat"><b><?= $n('productos') ?></b><span>Productos</span></div>
        <div class="stat"><b><?= $n('pedidos') ?></b><span>Pedidos</span></div>
        <div class="stat"><b><?= $n('usuarios') ?></b><span>Usuarios</span></div>
        <div class="stat"><b><?= precio($ventas) ?></b><span>Ventas</span></div>
    </div>
    <div class="total">
        <h2>Productos</h2>
        <a class="btn" href="producto_form.php">Agregar producto</a>
    </div>
    <?php if ($productos): ?>
    <div class="tabla-wrap">
    <table>
        <thead><tr><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Stock</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= e($producto['nombre']) ?></td>
                <td><?= e($producto['categoria'] ?? '-') ?></td>
                <td><?= precio($producto['precio']) ?></td>
                <td><?= (int)$producto['stock'] ?></td>
                <td><a class="btn chico borde" href="producto_form.php?id=<?= (int)$producto['id'] ?>">Editar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php else: ?>
        <p class="lead">Todavía no hay productos. Usa «Agregar producto» para crear el primero.</p>
    <?php endif; ?>
    <br><a href="productos.php">Ver y administrar todos los productos</a>
    <br><br>
    <h2>Últimos mensajes</h2>
    <?php if ($msgs): foreach ($msgs as $m): ?>
        <div class="alerta"><b><?= e($m['nombre']) ?></b> (<?= e($m['email']) ?>) — <small><?= e($m['fecha']) ?></small><br><?= nl2br(e($m['mensaje'])) ?></div>
    <?php endforeach; else: ?><p class="lead">No hay mensajes todavía.</p><?php endif; ?>
</section>
<?php include '../includes/footer.php'; ?>
