<?php
require '../vendor/autoload.php';

use Clases\Clases1\ClasesOperacionesExamen2Service;

$host        = "localhost";
$urlrelativo = "/EXAMEN2-DWCS/UNIDAD-07-01/servidorSoap";
$uri         = "http://" . $host . $urlrelativo;
$url         = $uri . "/servicio.wsdl";

try {
    $cliente = new SoapClient($url);
} catch (SoapFault $f) {
    die("Error en cliente SOAP:" . $f->getMessage());
}

$codP = 13;

//---------------------------------------------------------------------------------------
$objeto = new ClasesOperacionesExamen2Service();

foreach ($objeto->getTiendas($codP) as $tienda) {
    echo "Tienda: " . $tienda->nombre . "<br>";
    echo "Telefono: " . $tienda->tlf . "<br>";
    echo "Unidades: " . $tienda->unidades . "<br>";
    echo "<br>";
}

