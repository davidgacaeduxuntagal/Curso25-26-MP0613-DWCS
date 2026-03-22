<?php
require '../vendor/autoload.php';

$host        = "localhost";
$urlrelativo = "EXAMEN2-DWCS/UNIDAD-06-01/servidorSoap";
$uri         = "http://" . $host . $urlrelativo;
$url         = $uri . "/servicio.wsdl";

$parametros = ['uri' => $url];

try {
    $server = new SoapServer(NULL, $parametros);
    $server->setClass('Clases\OperacionesExamen2');
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}