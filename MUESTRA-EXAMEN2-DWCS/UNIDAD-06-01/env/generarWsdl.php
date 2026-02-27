<?php
require '../vendor/autoload.php';

use PHP2WSDL\PHPClass2WSDL;

$host = "localhost";
$urlrelativo = "/EXAMEN2-DWCS/UNIDAD-06-01/servidorSoap";
$uri = "http://" . $host . $urlrelativo;
$url = $uri . "/servicio.php";


$class = "Clases\\OperacionesExamen2";
$wsdlGenerator = new PHPClass2WSDL($class, $url);
$wsdlGenerator->generateWSDL(true);
$fichero = $wsdlGenerator->save('../servidorSoap/servicio.wsdl');
