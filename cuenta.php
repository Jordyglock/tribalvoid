<?php
require_once 'config/conexion.php';
requiereLogin();

if (empty($_SESSION['cancelar_pedido_token'])) {
    $_SESSION['cancelar_pedido_token'] = bin2hex(random_bytes(32));
}

$mensajesError = [
    'token' => 'No se pudo validar la solicitud. Recarga la página e inténtalo de nuevo.',
    'no-encontrado' => 'No se encontró ese pedido en tu cuenta.',
    'no-pendiente' => 'Solo puedes cancelar pedidos que todavía están pendientes.',
    'fallo' => 'No se pudo cancelar el pedido. Inténtalo más tarde o contacta con la tienda.',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'cancelar_pedido') {
    if (
        !isset($_POST['token'], $_SESSION['cancelar_pedido_token'])
        || !is_string($_POST['token'])
        || !hash_equals($_SESSION['cancelar_pedido_token'], $_POST['token'])
    ) {
        header('Location: cuenta.php?error=token');
        exit;
    }

    $pedidoId = filter_input(INPUT_POST, 'pedido_id', FILTER_VALIDATE_INT);
    if (!$pedidoId || $pedidoId < 1) {
        header('Location: cuenta.php?error=no-encontrado');
        exit;
    }

    try {
        $pdo->beginTransaction();
        $pedido = $pdo->prepare("SELECT estado FROM pedidos WHERE id = ? AND usuario_id = ? FOR UPDATE");
        $pedido->execute([$pedidoId, $_SESSION['uid']]);
        $pedido = $pedido->fetch();

        if (!$pedido) {
            $pdo->rollBack();
            header('Location: cuenta.php?error=no-encontrado');
            exit;
        }
        if ($pedido['estado'] !== 'pendiente') {
            $pdo->rollBack();
            header('Location: cuenta.php?error=no-pendiente');
            exit;
        }

        restaurarInventarioPedido($pdo, $pedidoId);
        $actualizar = $pdo->prepare("UPDATE pedidos SET estado = 'cancelado' WHERE id = ? AND estado = 'pendiente'");
        $actualizar->execute([$pedidoId]);
        if ($actualizar->rowCount() !== 1) {
            throw new RuntimeException('El estado del pedido cambió durante la cancelación.');
        }
        $pdo->commit();
        header('Location: cuenta.php?cancelado=' . $pedidoId);
        exit;
    } catch (PDOException $ex) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Error de base de datos al cancelar el pedido #' . $pedidoId . ': ' . $ex->getMessage());
        header('Location: cuenta.php?error=fallo');
        exit;
    } catch (RuntimeException $ex) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('No se pudo cancelar el pedido #' . $pedidoId . ': ' . $ex->getMessage());
        header('Location: cuenta.php?error=fallo');
        exit;
    }
}

$st = $pdo->prepare("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY id DESC");
$st->execute([$_SESSION['uid']]);
$pedidos = $st->fetchAll();
$codigoError = $_GET['error'] ?? '';
if (!is_string($codigoError)) {
    $codigoError = '';
}
$titulo = 'Mi cuenta';
include 'includes/header.php';
?>
<section class="seccion medio">
    <h2>Mis pedidos</h2>
    <?php if (!empty($_GET['ok'])): ?><div class="alerta">Pedido #<?= (int)$_GET['ok'] ?> recibido. Te contactaremos para coordinar el pago y el envío.</div><?php endif; ?>
    <?php if (!empty($_GET['cancelado'])): ?><div class="alerta">Pedido #<?= (int)$_GET['cancelado'] ?> cancelado. El inventario reservado fue liberado.</div><?php endif; ?>
    <?php if (isset($mensajesError[$codigoError])): ?><div class="alerta error"><?= e($mensajesError[$codigoError]) ?></div><?php endif; ?>
    <?php if ($pedidos): foreach ($pedidos as $pd): ?>
        <div class="alerta">
            <b>Pedido #<?= $pd['id'] ?></b> — <?= e(date('d/m/Y', strtotime($pd['fecha']))) ?> —
            <span class="estado <?= e($pd['estado']) ?>"><?= e($pd['estado']) ?></span> — <?= precio($pd['total']) ?>
            <?php
            $d = $pdo->prepare("SELECT d.*, p.nombre FROM detalle_pedido d JOIN productos p ON p.id = d.producto_id WHERE d.pedido_id = ?");
            $d->execute([$pd['id']]);
            foreach ($d->fetchAll() as $x): ?>
                <br><small><?= (int)$x['cantidad'] ?> × <?= e($x['nombre']) ?> (<?= e($x['talla']) ?>)</small>
            <?php endforeach; ?>
            <?php if ($pd['estado'] === 'pendiente'): ?>
                <br>
                <form method="post" class="inline" onsubmit="return confirm('¿Seguro que deseas cancelar este pedido?');">
                    <input type="hidden" name="accion" value="cancelar_pedido">
                    <input type="hidden" name="pedido_id" value="<?= (int)$pd['id'] ?>">
                    <input type="hidden" name="token" value="<?= e($_SESSION['cancelar_pedido_token']) ?>">
                    <button class="btn chico peligro" type="submit">Cancelar pedido</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; else: ?>
        <p class="lead">Todavía no has hecho pedidos.</p><br><a class="btn" href="tienda.php">Ir a la tienda</a>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>
