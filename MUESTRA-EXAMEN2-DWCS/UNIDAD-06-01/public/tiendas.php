<?php
error_reporting(E_ALL & ~E_DEPRECATED);

session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location:login.php');
}

require '../vendor/autoload.php';

use Philo\Blade\Blade;
use Clases\Clases1\ClasesOperacionesExamen2Service;


$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);

$host        = "localhost";
$urlrelativo = "/EXAMEN2-DWCS/UNIDAD-06-01/servidorSoap";
$uri         = "http://" . $host . $urlrelativo;
$url         = $uri . "/servicio.wsdl";

try {
    $cliente = new SoapClient($url);
} catch (SoapFault $f) {
    die("Error en cliente SOAP:" . $f->getMessage());
}

//---------------------------------------------------------------------------------------
$objeto = new ClasesOperacionesExamen2Service();

foreach ($objeto->getTiendas($_GET['id']) as $tienda) {
    $tiendas[] = $tienda;
}

$cantidad = 0;
if (isset($_SESSION['cesta'])) {
    $cantidad = count($_SESSION['cesta']);
}

$titulo     = 'Tiendas';
$encabezado = 'Tiendas con productos';
$usuario    = $_SESSION['nombre'];
echo $blade
    ->view()
    ->make('vistaTiendas', compact('titulo', 'encabezado', 'usuario', 'cantidad', 'tiendas'))
    ->render();



