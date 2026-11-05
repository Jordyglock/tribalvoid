<?php
// ====== CONFIGURACIÓN (cambia estos valores) ======
define('MARCA', 'TRIBAL VOID');      // Nombre de la marca de tu amigo
$directorioScript = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
$directorioScript = rtrim($directorioScript, '/.');
if (basename($directorioScript) === 'admin') {
    $directorioScript = dirname($directorioScript);
}
define('BASE', rtrim($directorioScript, '/') . '/');
$DB_HOST = 'localhost';
$DB_NAME = 'marca_dark';
$DB_USER = 'root';
$DB_PASS = '';
// ===================================================

if (session_status() === PHP_SESSION_NONE) session_start();

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $ex) {
    die('No se pudo conectar a la base de datos: ' . $ex->getMessage());
}

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function precio($n) { return '$' . number_format((int)$n, 0, ',', '.'); }
function esAdmin() { return ($_SESSION['rol'] ?? '') === 'admin'; }
function requiereLogin() {
    if (empty($_SESSION['uid'])) { header('Location: ' . BASE . 'login.php?volver=1'); exit; }
}
function requiereAdmin() {
    if (!esAdmin()) { header('Location: ' . BASE . 'login.php'); exit; }
}
function restaurarInventarioPedido(PDO $pdo, int $pedidoId) {
    $detalle = $pdo->prepare("SELECT producto_id, talla, cantidad FROM detalle_pedido WHERE pedido_id = ?");
    $detalle->execute([$pedidoId]);
    foreach ($detalle->fetchAll() as $item) {
        $stock = $pdo->prepare("UPDATE tallas_producto SET stock = stock + ? WHERE producto_id = ? AND talla = ?");
        $stock->execute([(int)$item['cantidad'], (int)$item['producto_id'], $item['talla']]);
        if ($stock->rowCount() !== 1) {
            throw new RuntimeException('No se encontró una talla del pedido al restaurar el inventario.');
        }
    }
}
function imgProducto($img) {
    if (!$img) return BASE . 'assets/img/emblema.svg';
    $ruta = str_replace('\\', '/', trim((string)$img));
    $marcaAssets = 'assets/img/';
    $posicionAssets = stripos($ruta, $marcaAssets);
    if ($posicionAssets !== false) {
        $ruta = substr($ruta, $posicionAssets + strlen($marcaAssets));
    } elseif (preg_match('/^(?:[a-z]:\/|\/)/i', $ruta)) {
        return BASE . 'assets/img/emblema.svg';
    } elseif (strpos($ruta, '/') === false) {
        $ruta = 'productos/' . $ruta;
    }

    $segmentos = explode('/', $ruta);
    if (in_array('..', $segmentos, true) || in_array('.', $segmentos, true)) {
        return BASE . 'assets/img/emblema.svg';
    }
    $ruta = implode('/', array_map('rawurlencode', $segmentos));
    return BASE . 'assets/img/' . $ruta;
}
function tarjeta($p) { ?>
    <a class="card" href="<?= BASE ?>producto.php?id=<?= (int)$p['id'] ?>">
        <div class="card-img <?= $p['imagen'] ? '' : 'vacia' ?>">
            <img src="<?= imgProducto($p['imagen']) ?>" alt="<?= e($p['nombre']) ?>" loading="lazy">
        </div>
        <div class="card-info">
            <h3><?= e($p['nombre']) ?></h3>
            <span><?= precio($p['precio']) ?></span>
        </div>
    </a>
<?php }
