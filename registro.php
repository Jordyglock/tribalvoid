<?php
require_once 'config/conexion.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = trim($_POST['nombre'] ?? ''); $m = trim($_POST['email'] ?? ''); $p = $_POST['password'] ?? '';
    if ($n === '' || !filter_var($m, FILTER_VALIDATE_EMAIL)) $error = 'Escribe tu nombre y un correo válido.';
    elseif (strlen($p) < 6) $error = 'La contraseña debe tener mínimo 6 caracteres.';
    else {
        $st = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $st->execute([$m]);
        if ($st->fetch()) $error = 'Ese correo ya tiene una cuenta. Prueba entrando.';
        else {
            $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?,?,?)")
                ->execute([$n, $m, password_hash($p, PASSWORD_DEFAULT)]);
            session_regenerate_id(true);
            $_SESSION['uid'] = $pdo->lastInsertId();
            $_SESSION['nombre'] = $n;
            $_SESSION['rol'] = 'cliente';
            header('Location: tienda.php'); exit;
        }
    }
}
$titulo = 'Crear cuenta';
include 'includes/header.php';
?>
<section class="seccion angosta">
    <h2>Crear cuenta</h2>
    <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form">
        <label class="campo">Nombre <input type="text" name="nombre" required value="<?= e($_POST['nombre'] ?? '') ?>"></label>
        <label class="campo">Correo <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>"></label>
        <label class="campo">Contraseña (mínimo 6 caracteres) <input type="password" name="password" required></label>
        <button class="btn" type="submit">Crear cuenta</button>
    </form>
</section>
<?php include 'includes/footer.php'; ?>
