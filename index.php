<?php
require_once 'config/conexion.php';
$titulo = 'Inicio';
$destacados = $pdo->query("SELECT * FROM productos WHERE destacado = 1 ORDER BY id DESC LIMIT 4")->fetchAll();
include 'includes/header.php';
?>
<section class="hero">
    <div class="hero-emblema" aria-hidden="true"><img src="<?= BASE ?>assets/img/emblema.svg" alt=""></div>
    <div class="hero-texto">
        <h1><?= e(MARCA) ?></h1>
        <p>Ropa oscura con marca propia. Estampados neotribales, cortes anchos y tirajes cortos.</p>
        <a class="btn" href="<?= BASE ?>tienda.php">Ver la tienda</a>
    </div>
</section>

<div class="cinta" aria-hidden="true"><span>Nueva colección &nbsp;&nbsp; Tiraje limitado &nbsp;&nbsp; Hecho a mano &nbsp;&nbsp; Nueva colección &nbsp;&nbsp; Tiraje limitado &nbsp;&nbsp; Hecho a mano</span></div>

<section class="seccion medio">
    <h2>Lo más pedido</h2>
    <?php if ($destacados): ?>
    <div class="grid"><?php foreach ($destacados as $p) tarjeta($p); ?></div>
    <?php else: ?>
        <p class="lead">Aún no hay productos destacados. Márcalos desde el panel de administración.</p>
    <?php endif; ?>
</section>

<div class="divider" aria-hidden="true"></div>

<section class="seccion medio dos">
    <div>
        <h2>Diseñado de noche, usado en la calle</h2>
        <p class="lead">Cada estampado nace de un boceto a mano y se pasa a vector con trazos cerrados y puntas largas. Las prendas se producen en tiradas pequeñas y no se vuelven a fabricar.</p>
        <br>
        <a class="btn borde" href="<?= BASE ?>nosotros.php">Conocer la marca</a>
    </div>
    <div class="bloque-tribal"><img src="<?= BASE ?>assets/img/emblema.svg" alt="Emblema tribal de la marca"></div>
</section>
<?php include 'includes/footer.php'; ?>
