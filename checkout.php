<?php
require_once 'config/conexion.php';
requiereLogin();
if (empty($_SESSION['carrito'])) { header('Location: carrito.php'); exit; }

$lineas = []; $total = 0;
foreach ($_SESSION['carrito'] as $it) {
    $st = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $st->execute([$it['id']]);
    if ($p = $st->fetch()) {
        $total += $p['precio'] * $it['cant'];
        $lineas[] = ['p' => $p, 'talla' => $it['talla'], 'cant' => $it['cant']];
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dir = trim($_POST['direccion'] ?? '');
    $tel = trim($_POST['telefono'] ?? '');
    if ($dir === '' || $tel === '') {
        $error = 'Completa la dirección y el teléfono para poder enviarte el pedido.';
    } else {
        try {
            $pdo->beginTransaction();
            $pdo->prepare("INSERT INTO pedidos (usuario_id, total, direccion, telefono) VALUES (?,?,?,?)")
                ->execute([$_SESSION['uid'], $total, $dir, $tel]);
            $pid = $pdo->lastInsertId();
            foreach ($lineas as $l) {
                $up = $pdo->prepare("UPDATE tallas_producto SET stock = stock - ? WHERE producto_id = ? AND talla = ? AND stock >= ?");
                $up->execute([$l['cant'], $l['p']['id'], $l['talla'], $l['cant']]);
                if ($up->rowCount() === 0) throw new Exception('Ya no queda stock de ' . $l['p']['nombre'] . ' en talla ' . $l['talla'] . '. Ajusta tu carrito.');
                $pdo->prepare("INSERT INTO detalle_pedido (pedido_id, producto_id, talla, cantidad, precio_unitario) VALUES (?,?,?,?,?)")
                    ->execute([$pid, $l['p']['id'], $l['talla'], $l['cant'], $l['p']['precio']]);
            }
            $pdo->commit();
            $_SESSION['carrito'] = [];
            header('Location: cuenta.php?ok=' . $pid); exit;
        } catch (Exception $ex) {
            $pdo->rollBack();
            $error = $ex->getMessage();
        }
    }
}
$titulo = 'Finalizar pedido';
include 'includes/header.php';
?>
<section class="seccion medio dos" style="align-items:start">
    <div>
        <h2>Datos de envío</h2>
        <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="form">
            <label class="campo">Dirección completa
                <input type="text" name="direccion" required value="<?= e($_POST['direccion'] ?? '') ?>">
            </label>
            <label class="campo">Teléfono
                <input type="tel" name="telefono" required value="<?= e($_POST['telefono'] ?? '') ?>">
            </label>
            <p class="lead">El pago se coordina por contraentrega o transferencia después de confirmar el pedido.</p>
            <button class="btn" type="submit">Confirmar pedido</button>
        </form>
    </div>
    <div>
        <h2>Resumen</h2>
        <?php foreach ($lineas as $l): ?>
            <p><?= (int)$l['cant'] ?> × <?= e($l['p']['nombre']) ?><?= $l['talla'] === 'Única' ? '' : ' (' . e($l['talla']) . ')' ?> — <?= precio($l['p']['precio'] * $l['cant']) ?></p>
        <?php endforeach; ?>
        <div class="total"><span>Total: <b><?= precio($total) ?></b></span></div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
