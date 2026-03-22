<?php
session_start();

if (isset($_SESSION['nombre'])) {
    setcookie('nombreCerrar', $_SESSION['nombre'], time() + 3600 * 24 * 365);
    setcookie('ultimoLogout', date('d-m-Y H:i:s'), time() + 3600 * 24 * 365);
}

unset($_SESSION['nombre']);

header('Location:login.php');