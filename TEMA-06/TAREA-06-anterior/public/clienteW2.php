<?php
error_reporting(E_ALL & ~E_DEPRECATED);

require '../vendor/autoload.php';

use Clases\Clases1\ClasesOperacionesService;

$host        = "dwcs.localhost";
$urlrelativo = "/TEMA-06/TAREA-06-anterior/servidorSoap";
$uri         = "http://" . $host . $urlrelativo;
$url         = $uri . "/servicio.wsdl";

try {
    $cliente = new SoapClient($url);
} catch (SoapFault $f) {
    die("Error en cliente SOAP:" . $f->getMessage());
}

$codP = 13;
$codT = 1;
$codF = 'MP3';

//---------------------------------------------------------------------------------------
$objeto = new ClasesOperacionesService();
// Añadir cookie para depuración con XDEBUG si queremos 
//  depurar la invocación del servicio.php al ser invocada
//  por la solicitud HTTP SOAP iniciada desde el cliente.
//  Parámetros de configuración de XDEBUG en php.ini:
//  [xdebug]
//  xdebug.mode=debug
//  xdebug.start_with_request=trigger
//  xdebug.client_host=127.0.0.1
//  xdebug.client_port=9003
// $objeto->__setCookie('XDEBUG_SESSION', 'VSCODE');


//funcion getPvp ------------------------------------------------------------------------
$pvp = $objeto->getPvp($codP);
$precio = ($pvp == null) ? "No existe es Producto" : $pvp;
echo "Código de producto de Código $codP: $precio";


//funcion getFamilias -------------------------------------------------------------------
echo "<br>Códigos de Familas:";
$prueba = $objeto->getFamilias();
echo "<ul>";
foreach ($prueba as $k => $v) {
    echo "<code><li>$v</li></code>";
}
echo "</ul>";


//funcion getProductosFamila ------------------------------------------------------------
$productos = $objeto->getProductosFamilia($codF);
echo "<br>Productos de la Famila $codF:";
$prueba = $objeto->getProductosFamilia($codF);
echo "<ul>";
foreach ($prueba as $k => $v) {
    echo "<code><li>$v</li></code>";
}
echo "</ul>";


// funcion getStock ---------------------------------------------------------------------
$unidades = $objeto->getStock($codP, $codT);
echo "<br>Unidades del producto de código $codP en la tienda de código $codT: $unidades";
