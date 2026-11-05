<?php
require_once '../config/conexion.php';
requiereAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'eliminar') {
    $id = (int)$_POST['id'];
    try {
        $pdo->prepare("DELETE FROM productos WHERE id = ?")->execute([$id]);
        $msg = 'Producto eliminado.';
    } catch (PDOException $ex) {
        $msg = 'No se puede eliminar: el producto ya está en pedidos. Pon su stock en 0 para ocultarlo.';
    }
}
$lista = $pdo->query("SELECT p.*, c.nombre AS cat, (SELECT COALESCE(SUM(stock),0) FROM tallas_producto WHERE producto_id = p.id) AS stock FROM productos p LEFT JOIN categorias c ON c.id = p.categoria_id ORDER BY p.id DESC")->fetchAll();
$titulo = 'Productos';
include '../includes/header.php';
include '../includes/admin_nav.php';
?>
<section class="seccion medio">
    <h2>Productos</h2>
    <?php if (!empty($msg)): ?><div class="alerta"><?= e($msg) ?></div><?php endif; ?>
    <a class="btn" href="producto_form.php">Nuevo producto</a><br><br>
    <div class="tabla-wrap">
    <table>
        <thead><tr><th></th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Stock</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($lista as $p): ?>
            <tr>
                <td><img src="<?= imgProducto($p['imagen']) ?>" alt=""></td>
                <td><?= e($p['nombre']) ?><?= $p['destacado'] ? ' <small>(destacado)</small>' : '' ?></td>
                <td><?= e($p['cat'] ?? '-') ?></td>
                <td><?= precio($p['precio']) ?></td>
                <td><?= (int)$p['stock'] ?></td>
                <td class="inline">
                    <a class="btn chico borde" href="producto_form.php?id=<?= $p['id'] ?>">Editar</a>
                    <form method="post"><input type="hidden" name="accion" value="eliminar"><input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button class="btn chico peligro" type="submit" data-confirmar="¿Eliminar este producto?">Eliminar</button></form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>
<?php include '../includes/footer.php'; ?>
