<?php
require_once 'config/conexion.php';
$titulo = 'Tienda';
$cat = (int)($_GET['cat'] ?? 0);
$q = trim($_GET['q'] ?? '');

$sql = "SELECT * FROM productos WHERE 1";
$params = [];
if ($cat) { $sql .= " AND categoria_id = ?"; $params[] = $cat; }
if ($q !== '') { $sql .= " AND (nombre LIKE ? OR descripcion LIKE ?)"; $params[] = "%$q%"; $params[] = "%$q%"; }
$sql .= " ORDER BY id DESC";
$st = $pdo->prepare($sql);
$st->execute($params);
$productos = $st->fetchAll();
$categorias = $pdo->query("SELECT * FROM categorias ORDER BY id")->fetchAll();
include 'includes/header.php';
?>
<section class="seccion medio">
    <h2>Tienda</h2>
    <div class="filtros">
        <a href="tienda.php" class="<?= !$cat ? 'activo' : '' ?>">Todo</a>
        <?php foreach ($categorias as $c): ?>
            <a href="tienda.php?cat=<?= (int)$c['id'] ?>" class="<?= $cat === (int)$c['id'] ? 'activo' : '' ?>"><?= e($c['nombre']) ?></a>
        <?php endforeach; ?>
        <form method="get">
            <?php if ($cat): ?><input type="hidden" name="cat" value="<?= $cat ?>"><?php endif; ?>
            <input type="text" name="q" placeholder="Buscar prenda" value="<?= e($q) ?>">
            <button class="btn chico" type="submit">Buscar</button>
        </form>
    </div>
    <?php if ($productos): ?>
        <div class="grid"><?php foreach ($productos as $p) tarjeta($p); ?></div>
    <?php else: ?>
        <p class="lead">No encontramos prendas con ese filtro. Prueba otra categoría o borra la búsqueda.</p>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>
