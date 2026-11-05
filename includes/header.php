<?php
require_once __DIR__ . '/../config/conexion.php';
$items = array_sum(array_column($_SESSION['carrito'] ?? [], 'cant'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titulo ?? 'Inicio') ?> | <?= e(MARCA) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=UnifrakturCook:wght@700&family=Space+Grotesk:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE ?>assets/css/estilos.css">
</head>
<body>
<div class="grain" aria-hidden="true"></div>
<header class="topbar">
    <a class="logo" href="<?= BASE ?>index.php"><?= e(MARCA) ?></a>
    <button class="burger" id="burger" aria-label="Abrir menú">Menú</button>
    <nav id="nav">
        <a href="<?= BASE ?>tienda.php">Tienda</a>
        <a href="<?= BASE ?>nosotros.php">Nosotros</a>
        <a href="<?= BASE ?>contacto.php">Contacto</a>
        <a href="<?= BASE ?>carrito.php">Carrito (<?= (int)$items ?>)</a>
        <?php if (!empty($_SESSION['uid'])): ?>
            <?php if (esAdmin()): ?><a href="<?= BASE ?>admin/index.php">Administrador</a><?php endif; ?>
            <a href="<?= BASE ?>cuenta.php"><?= esAdmin() ? 'Mi cuenta' : e(explode(' ', $_SESSION['nombre'])[0]) ?></a>
            <a href="<?= BASE ?>logout.php">Salir</a>
        <?php else: ?>
            <a href="<?= BASE ?>login.php">Entrar</a>
        <?php endif; ?>
    </nav>
</header>
<main>
