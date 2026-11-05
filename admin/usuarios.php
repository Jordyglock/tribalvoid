<?php
require_once '../config/conexion.php';
requiereAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = (int)$_POST['id'];
    if ($uid !== (int)$_SESSION['uid'] && in_array($_POST['rol'] ?? '', ['cliente', 'admin'])) {
        $pdo->prepare("UPDATE usuarios SET rol = ? WHERE id = ?")->execute([$_POST['rol'], $uid]);
    }
    header('Location: usuarios.php'); exit;
}
$usuarios = $pdo->query("SELECT * FROM usuarios ORDER BY id")->fetchAll();
$titulo = 'Usuarios';
include '../includes/header.php';
include '../includes/admin_nav.php';
?>
<section class="seccion medio">
    <h2>Usuarios</h2>
    <div class="tabla-wrap">
    <table>
        <thead><tr><th>#</th><th>Nombre</th><th>Correo</th><th>Registro</th><th>Rol</th></tr></thead>
        <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td><td><?= e($u['nombre']) ?></td><td><?= e($u['email']) ?></td>
                <td><?= e(date('d/m/Y', strtotime($u['fecha_registro']))) ?></td>
                <td>
                    <?php if ((int)$u['id'] === (int)$_SESSION['uid']): ?><?= e($u['rol']) ?> (tú)
                    <?php else: ?>
                    <form method="post" class="inline">
                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                        <select name="rol"><?php foreach (['cliente', 'admin'] as $r): ?><option <?= $u['rol'] === $r ? 'selected' : '' ?>><?= $r ?></option><?php endforeach; ?></select>
                        <button class="btn chico borde" type="submit">Guardar</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>
<?php include '../includes/footer.php'; ?>
