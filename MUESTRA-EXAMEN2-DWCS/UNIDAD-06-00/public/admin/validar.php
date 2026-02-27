<?php

session_start();

include '../../env/administradores.inc.php';

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

    foreach ($administradores as $nombreUsuario => $password) {
        if ($nombreUsuario == $nombre &&  $password == $pass) {
            $_SESSION['nombre'] = $nombre;
            header('Location: ../listado.php');
            die();
        }
    }

    error("Credenciales Inválidas");
} else {
    error("No se enviaron credenciales");
}
?>