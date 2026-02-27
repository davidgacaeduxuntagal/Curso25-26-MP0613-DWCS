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

// Añadir la cookie para almacenar el nombre de usuario y último login
$mensaje = '';
if ( isset($_SESSION['seAcabaDeLogear']) ) {
    unset($_SESSION['seAcabaDeLogear']);
    
    // Procesar mensaje login
    $mensaje = "Empiezas desde una nueva sesión";
    if ( isset($_COOKIE['nombre']) ) {
        if ( $_COOKIE['nombre'] == $_SESSION['nombre'] ) {
            $mensaje = "Último login: " . $_COOKIE['ultimoLogin'];
            
            // Procesar mensaje logout
            if ( isset($_COOKIE['nombreCerrar']) && $_COOKIE['nombreCerrar'] == $_SESSION['nombre'] ) {
                $mensaje .= " --- Último logout: " . $_COOKIE['ultimoLogout'];
            }
        } else {
            unset($_SESSION['cesta']);
        }
    }
    setcookie('nombre', $_SESSION['nombre'], time() + 3600 * 24 * 365);
    setcookie('ultimoLogin', date('d-m-Y H:i:s'), time() + 3600 * 24 * 365);   
}

if (isset($_POST['vaciar'])) {
    unset($_SESSION['cesta']);
}

if (isset($_POST['comprar'])) {
    $datos = (new Producto())->consultarProducto($_POST['id']);
    $_SESSION['cesta'][$datos->id] = $datos->id;
}

$cantidad = 0;
if (isset($_SESSION['cesta'])) {
    $cantidad = count($_SESSION['cesta']);
}

if (isset($_SESSION['nombre'])) {
    $titulo     = 'Listado';
    $encabezado = 'Tienda onLine';
    $usuario    = $_SESSION['nombre'];
    $productos  = (new Producto())->recuperarProductos();
    $action     = $_SERVER['PHP_SELF'];
    $cesta      = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : [];
    echo $blade
        ->view()
        ->make('vistaListado', compact('titulo', 'encabezado', 'usuario', 'cantidad', 'action', 'cesta', 'productos', 'mensaje'))
        ->render();
} else {
    echo $blade
        ->view()
        ->make('vistaLogin')
        ->render();
}