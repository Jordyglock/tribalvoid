<?php
require_once 'config/conexion.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $st->execute([trim($_POST['email'] ?? '')]);
    $u = $st->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['uid'] = $u['id'];
        $_SESSION['nombre'] = $u['nombre'];
        $_SESSION['rol'] = $u['rol'];
        header('Location: ' . ($u['rol'] === 'admin' ? 'admin/index.php' : 'tienda.php')); exit;
    }
    $error = 'Correo o contraseña incorrectos.';
}
$titulo = 'Entrar';
include 'includes/header.php';
?>
<section class="seccion angosta">
    <h2>Entrar</h2>
    <?php if (isset($_GET['volver'])): ?><div class="alerta">Inicia sesión para finalizar tu pedido.</div><?php endif; ?>
    <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form">
        <label class="campo">Correo <input type="email" name="email" required></label>
        <label class="campo">Contraseña <input type="password" name="password" required></label>
        <button class="btn" type="submit">Entrar</button>
    </form>
    <br><p class="lead">¿No tienes cuenta? <a href="registro.php" style="color:#fff;text-decoration:underline">Crea una</a>.</p>
</section>
<?php include 'includes/footer.php'; ?>
