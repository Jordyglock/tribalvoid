<?php
require_once 'config/conexion.php';
$_SESSION = [];
session_destroy();
header('Location: index.php');
