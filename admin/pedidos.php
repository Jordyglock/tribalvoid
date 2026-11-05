<?php
require_once '../config/conexion.php';
requiereAdmin();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = $_POST['estado'] ?? '';
    if (in_array($estado, ['pendiente', 'enviado', 'entregado', 'cancelado'])) {
        $pedidoId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($pedidoId && $pedidoId > 0) {
            try {
                $pdo->beginTransaction();
                $consulta = $pdo->prepare("SELECT estado FROM pedidos WHERE id = ? FOR UPDATE");
                $consulta->execute([$pedidoId]);
                $pedidoActual = $consulta->fetch();

                if ($pedidoActual && $pedidoActual['estado'] === 'cancelado' && $estado !== 'cancelado') {
                    $pdo->rollBack();
                    header('Location: pedidos.php?error=no-reabrir');
                    exit;
                }
                if ($pedidoActual && $pedidoActual['estado'] !== 'cancelado' && $estado === 'cancelado') {
                    restaurarInventarioPedido($pdo, $pedidoId);
                }
                if ($pedidoActual) {
                    $pdo->prepare("UPDATE pedidos SET estado = ? WHERE id = ?")->execute([$estado, $pedidoId]);
                }
                $pdo->commit();
            } catch (PDOException $ex) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('Error al actualizar el pedido #' . $pedidoId . ': ' . $ex->getMessage());
                $error = 'No se pudo actualizar el pedido. Inténtalo de nuevo.';
            } catch (RuntimeException $ex) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log('No se pudo actualizar el pedido #' . $pedidoId . ': ' . $ex->getMessage());
                $error = 'No se pudo actualizar el pedido. Inténtalo de nuevo.';
            }
        }
    }
    if ($error === '') {
        header('Location: pedidos.php');
        exit;
    }
}
$pedidos = $pdo->query("SELECT pd.*, u.nombre, u.email,
    (SELECT GROUP_CONCAT(CONCAT(d.cantidad,' × ',p.nombre,' (',d.talla,')') SEPARATOR '<br>') FROM detalle_pedido d JOIN productos p ON p.id = d.producto_id WHERE d.pedido_id = pd.id) AS items
    FROM pedidos pd JOIN usuarios u ON u.id = pd.usuario_id ORDER BY pd.id DESC")->fetchAll();
$titulo = 'Pedidos';
include '../includes/header.php';
include '../includes/admin_nav.php';
?>
<section class="seccion medio">
    <h2>Pedidos</h2>
    <?php if (($_GET['error'] ?? '') === 'no-reabrir'): ?><div class="alerta error">Un pedido cancelado no se puede reabrir.</div><?php endif; ?>
    <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
    <?php if ($pedidos): ?>
    <div class="tabla-wrap">
    <table>
        <thead><tr><th>#</th><th>Cliente</th><th>Prendas</th><th>Envío</th><th>Total</th><th>Estado</th></tr></thead>
        <tbody>
        <?php foreach ($pedidos as $o): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= e($o['nombre']) ?><br><small><?= e($o['email']) ?></small></td>
                <td><small><?= str_replace('&lt;br&gt;', '<br>', e($o['items'] ?? '')) ?></small></td>
                <td><small><?= e($o['direccion']) ?><br><?= e($o['telefono']) ?></small></td>
                <td><?= precio($o['total']) ?></td>
                <td>
                    <?php if ($o['estado'] === 'cancelado'): ?>
                        <span class="estado cancelado">cancelado</span>
                    <?php else: ?>
                    <form method="post" class="inline">
                        <input type="hidden" name="id" value="<?= $o['id'] ?>">
                        <select name="estado">
                            <?php foreach (['pendiente', 'enviado', 'entregado', 'cancelado'] as $s): ?>
                                <option <?= $o['estado'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn chico borde" type="submit">Guardar</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php else: ?><p class="lead">Aún no hay pedidos.</p><?php endif; ?>
</section>
<?php include '../includes/footer.php'; ?>
