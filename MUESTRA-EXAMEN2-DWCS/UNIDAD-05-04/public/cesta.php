<?php
error_reporting(E_ALL & ~E_DEPRECATED);

session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location:login.php');
}

require '../vendor/autoload.php';

use Clases\Producto;
use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);

$total = 0;
$listado = [];
if (isset($_SESSION['cesta'])) {
    foreach ($_SESSION['cesta'] as $k => $v) {
        $producto = (new Producto())->consultarProducto($k);
        $listado[$k] = [$producto->nombre, $producto->pvp];
        $total += $producto->pvp;
        $producto = null;
    }
}

$cantidad = 0;
if (isset($_SESSION['cesta'])) {
    $cantidad = count($_SESSION['cesta']);
}

$titulo     = 'Cesta';
$encabezado = 'Comprar Productos';
$usuario    = $_SESSION['nombre'];
echo $blade
    ->view()
    ->make('vistaCesta', compact('titulo', 'encabezado', 'usuario', 'listado', 'cantidad', 'total'))
    ->render();



