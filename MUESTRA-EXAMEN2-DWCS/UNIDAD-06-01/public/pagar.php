<?php
error_reporting(E_ALL & ~E_DEPRECATED);

session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location:login.php');
}

require '../vendor/autoload.php';

use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);

$cantidad = 0;
if (isset($_SESSION['cesta'])) {
    $cantidad = count($_SESSION['cesta']);
}

$titulo     = 'Pagar';
$encabezado = 'Tienda onLine';
$usuario    = $_SESSION['nombre'];
echo $blade
    ->view()
    ->make('vistaPagar', compact('titulo', 'encabezado', 'usuario', 'cantidad'))
    ->render();
