<?php
require_once 'config/conexion.php';
$titulo = 'Nosotros';
include 'includes/header.php';
?>
<section class="seccion medio dos">
    <div>
        <h2>Sobre <?= e(MARCA) ?></h2>
        <p class="lead">Somos una marca independiente de ropa de estilo alternativo. Nuestros diseños mezclan trazos neotribales, tipografía gótica y una paleta de negros, blancos y grises.</p>
        <br>
        <p class="lead">Edita este texto con la historia real de la marca: quién la fundó, desde cuándo existe y dónde se produce.</p>
    </div>
    <div class="bloque-tribal"><img src="<?= BASE ?>assets/img/emblema.svg" alt="Emblema tribal"></div>
</section>
<section class="seccion medio">
    <div class="valores">
        <div><h3>Tiraje corto</h3><p>Cada diseño se produce en pocas unidades y no se repite.</p></div>
        <div><h3>Hecho a mano</h3><p>Los bocetos se dibujan a mano antes de pasar a estampado.</p></div>
        <div><h3>Sin reglas de moda</h3><p>Cortes anchos, telas pesadas y prendas pensadas para durar.</p></div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
