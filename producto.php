<?php
require_once 'config/conexion.php';
$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare("SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON c.id = p.categoria_id WHERE p.id = ?");
$st->execute([$id]);
$p = $st->fetch();
if (!$p) { http_response_code(404); $titulo = 'No encontrado'; include 'includes/header.php';
    echo '<section class="seccion angosta"><h2>Prenda no encontrada</h2><a class="btn" href="tienda.php">Volver a la tienda</a></section>';
    include 'includes/footer.php'; exit; }
$st = $pdo->prepare("SELECT talla, stock FROM tallas_producto WHERE producto_id = ? AND stock > 0 ORDER BY FIELD(talla,'S','M','L','XL','Única')");
$st->execute([$id]);
$tallas = $st->fetchAll();
$st = $pdo->prepare("SELECT imagen FROM imagenes_producto WHERE producto_id = ? ORDER BY orden, id");
$st->execute([$id]);
$fotos = $st->fetchAll(PDO::FETCH_COLUMN);
if (!$fotos) $fotos = [$p['imagen']];
$tallaUnica = count($tallas) === 1 && $tallas[0]['talla'] === 'Única';
$titulo = $p['nombre'];
include 'includes/header.php';
?>
<section class="producto">
    <div class="producto-fotos">
        <?php foreach ($fotos as $i => $foto): ?>
            <div class="foto <?= $foto ? '' : 'vacia' ?>"><img src="<?= imgProducto($foto) ?>" alt="<?= e($p['nombre']) ?>, vista <?= $i + 1 ?>"></div>
        <?php endforeach; ?>
    </div>
    <div>
        <p class="lead"><?= e($p['categoria'] ?? 'Sin categoría') ?></p>
        <h1 style="font-size:clamp(2.2rem,5vw,3.6rem)"><?= e($p['nombre']) ?></h1>
        <p class="precio"><?= precio($p['precio']) ?></p>
        <p class="lead"><?= nl2br(e($p['descripcion'])) ?></p>
        <br>
        <?php if ($tallas): ?>
        <form method="post" action="carrito.php">
            <input type="hidden" name="accion" value="agregar">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <?php if ($tallaUnica): ?>
                <input type="hidden" name="talla" value="Única">
            <?php else: ?>
                <p>Talla</p>
                <div class="tallas">
                    <?php foreach ($tallas as $i => $t): ?>
                        <input type="radio" name="talla" id="t<?= $i ?>" value="<?= e($t['talla']) ?>" required <?= $i === 0 ? 'checked' : '' ?>>
                        <label for="t<?= $i ?>"><?= e($t['talla']) ?></label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <label class="campo" style="max-width:120px;margin-bottom:1.4rem">Cantidad
                <input type="number" name="cant" value="1" min="1" max="10">
            </label>
            <button class="btn" type="submit">Agregar al carrito</button>
        </form>
        <?php else: ?>
            <div class="alerta">Prenda agotada. Escríbenos desde la página de contacto si quieres que la repitamos.</div>
        <?php endif; ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
