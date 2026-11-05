
<?php
require_once 'config/conexion.php';
$_SESSION['carrito'] ??= [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $id = (int)($_POST['id'] ?? 0);
    $talla = $_POST['talla'] ?? '';
    $key = $id . '-' . $talla;

    if ($accion === 'agregar') {
        $cant = max(1, (int)($_POST['cant'] ?? 1));
        $st = $pdo->prepare("SELECT stock FROM tallas_producto WHERE producto_id = ? AND talla = ?");
        $st->execute([$id, $talla]);
        $stock = (int)$st->fetchColumn();
        if ($stock > 0) {
            $actual = $_SESSION['carrito'][$key]['cant'] ?? 0;
            $_SESSION['carrito'][$key] = ['id' => $id, 'talla' => $talla, 'cant' => min($stock, $actual + $cant)];
        }
    } elseif ($accion === 'quitar') {
        unset($_SESSION['carrito'][$key]);
    } elseif ($accion === 'actualizar' && isset($_SESSION['carrito'][$key])) {
        $st = $pdo->prepare("SELECT stock FROM tallas_producto WHERE producto_id = ? AND talla = ?");
        $st->execute([$id, $talla]);
        $nueva = max(1, min((int)$st->fetchColumn(), (int)($_POST['cant'] ?? 1)));
        $_SESSION['carrito'][$key]['cant'] = $nueva;
    }
    header('Location: carrito.php'); exit;
}

$lineas = []; $total = 0;
foreach ($_SESSION['carrito'] as $key => $it) {
    $st = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $st->execute([$it['id']]);
    if ($p = $st->fetch()) {
        $sub = $p['precio'] * $it['cant'];
        $total += $sub;
        $lineas[] = ['p' => $p, 'talla' => $it['talla'], 'cant' => $it['cant'], 'sub' => $sub];
    } else { unset($_SESSION['carrito'][$key]); }
}
$titulo = 'Carrito';
include 'includes/header.php';
?>
<section class="seccion medio">
    <h2>Tu carrito</h2>
    <?php if ($lineas): ?>
    <div class="tabla-wrap">
    <table>
        <thead><tr><th></th><th>Prenda</th><th>Talla</th><th>Cantidad</th><th>Subtotal</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($lineas as $l): ?>
            <tr>
                <td><img src="<?= imgProducto($l['p']['imagen']) ?>" alt=""></td>
                <td><a href="producto.php?id=<?= $l['p']['id'] ?>"><?= e($l['p']['nombre']) ?></a><br><small><?= precio($l['p']['precio']) ?></small></td>
                <td><?= $l['talla'] === 'Única' ? '—' : e($l['talla']) ?></td>
                <td>
                    <form method="post" class="inline">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="id" value="<?= $l['p']['id'] ?>">
                        <input type="hidden" name="talla" value="<?= e($l['talla']) ?>">
                        <input type="number" name="cant" value="<?= $l['cant'] ?>" min="1" max="10" style="width:70px">
                        <button class="btn chico borde" type="submit">Cambiar</button>
                    </form>
                </td>
                <td><?= precio($l['sub']) ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="accion" value="quitar">
                        <input type="hidden" name="id" value="<?= $l['p']['id'] ?>">
                        <input type="hidden" name="talla" value="<?= e($l['talla']) ?>">
                        <button class="btn chico peligro" type="submit">Quitar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <div class="total">
        <span>Total: <b><?= precio($total) ?></b></span>
        <a class="btn" href="checkout.php">Finalizar pedido</a>
    </div>
    <?php else: ?>
        <p class="lead">Tu carrito está vacío. Mira lo que hay en la tienda.</p><br>
        <a class="btn" href="tienda.php">Ir a la tienda</a>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>
