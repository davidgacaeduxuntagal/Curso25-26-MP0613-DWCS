<?php

session_start();
//Hacemos el autoload de las clases
require '../vendor/autoload.php';

use Clases\Cliente;

function error($mensaje)
{
    $_SESSION['error'] = $mensaje;
    header('Location: login.php');
    die();
}

if (isset($_POST['login'])) {
    $nombre = trim($_POST['usuario']);
    $pass = trim($_POST['pass']);
    if (strlen($nombre) == 0 || strlen($pass) == 0) {
        error("Error, El nombre o la contraseña no pueden contener solo espacios en blancos.");
    }
    $usuario = new Cliente();
    if (!$usuario->isValido($nombre, $pass)) {
        $usuario = null;
        error("Credenciales Inválidas");
    }
    $usuario = null;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['seAcabaDeLogear'] = true;  // simplemente definimos la variable de sesión, el valor no importará
    header('Location: listado.php');
}
?>