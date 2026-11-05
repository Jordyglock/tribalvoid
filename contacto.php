<?php
require_once 'config/conexion.php';

$pdo->exec("CREATE TABLE IF NOT EXISTS datos_contacto (
    id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
    correo VARCHAR(120) NOT NULL DEFAULT '',
    telefono VARCHAR(30) NOT NULL DEFAULT ''
)");
$pdo->exec("INSERT IGNORE INTO datos_contacto (id, correo, telefono) VALUES (1, '', '')");

$admin = esAdmin();
$ok = false;
$error = '';
$guardado = false;

if ($admin && empty($_SESSION['contacto_token'])) {
    $_SESSION['contacto_token'] = bin2hex(random_bytes(32));
}

if ($admin && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = isset($_POST['correo']) && is_string($_POST['correo']) ? trim($_POST['correo']) : '';
    $telefono = isset($_POST['telefono']) && is_string($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $token = $_POST['token'] ?? '';

    if (!is_string($token) || !hash_equals($_SESSION['contacto_token'], $token)) {
        $error = 'No se pudo validar la solicitud. Recarga la página e inténtalo de nuevo.';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($telefono) > 30) {
        $error = 'Escribe un correo válido y un teléfono de hasta 30 caracteres.';
    } else {
        $actualizar = $pdo->prepare("UPDATE datos_contacto SET correo = ?, telefono = ? WHERE id = 1");
        $actualizar->execute([$correo, $telefono]);
        $ok = true;
    }
} elseif (!$admin && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $n = trim($_POST['nombre'] ?? ''); $m = trim($_POST['email'] ?? ''); $t = trim($_POST['mensaje'] ?? '');
    if ($n === '' || $t === '' || !filter_var($m, FILTER_VALIDATE_EMAIL)) {
        $error = 'Revisa que el nombre, el correo y el mensaje estén completos y bien escritos.';
    } else {
        $pdo->prepare("INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES (?,?,?)")->execute([$n, $m, $t]);
        $ok = true;
    }
}

$datosContacto = $pdo->query("SELECT correo, telefono FROM datos_contacto WHERE id = 1")->fetch();
if (!$datosContacto) {
    throw new RuntimeException('No se pudieron cargar los datos de contacto.');
}

$titulo = 'Contacto';
include 'includes/header.php';
?>
<section class="seccion angosta">
    <?php if ($admin): ?>
        <h2>Datos de contacto</h2>
        <?php if ($ok): ?><div class="alerta">Datos de contacto actualizados.</div><?php endif; ?>
        <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
        <p class="lead">Los mensajes que envían los clientes se guardan en el panel de administración. El sitio todavía no los envía automáticamente por correo.</p><br>
        <form method="post" class="form">
            <input type="hidden" name="token" value="<?= e($_SESSION['contacto_token']) ?>">
            <label class="campo">Correo de contacto <input type="email" name="correo" required value="<?= e($_POST['correo'] ?? $datosContacto['correo']) ?>"></label>
            <label class="campo">Teléfono / WhatsApp <input type="tel" name="telefono" maxlength="30" value="<?= e($_POST['telefono'] ?? $datosContacto['telefono']) ?>"></label>
            <button class="btn" type="submit">Guardar datos de contacto</button>
        </form>
    <?php else: ?>
        <h2>Escríbenos</h2>
        <?php if ($ok): ?><div class="alerta">Mensaje recibido. Lo revisaremos desde el panel de administración.</div><?php endif; ?>
        <?php if ($error): ?><div class="alerta error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="form">
            <label class="campo">Nombre <input type="text" name="nombre" required></label>
            <label class="campo">Correo <input type="email" name="email" required></label>
            <label class="campo">Mensaje <textarea name="mensaje" required></textarea></label>
            <button class="btn" type="submit">Enviar mensaje</button>
        </form>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>
