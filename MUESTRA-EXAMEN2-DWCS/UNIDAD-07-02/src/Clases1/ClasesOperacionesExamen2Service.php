<?php

namespace Clases\Clases1;

class ClasesOperacionesExamen2Service extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
);

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null)
    {
    
  foreach (self::$classmap as $key => $value) {
    if (!isset($options['classmap'][$key])) {
      $options['classmap'][$key] = $value;
    }
  }
      $options = array_merge(array (
  'features' => 1,
), $options);
      if (!$wsdl) {
        $wsdl = 'http://localhost/EXAMEN2-DWCS/UNIDAD-07-02/servidorSoap/servicio.wsdl';
      }
      parent::__construct($wsdl, $options);
    }

    /**
     * Obtiene listado de tiendas en formato {nombre, telefono, unidades}
     *
     * @param int $idProducto
     * @return Array
     */
    public function getTiendas($idProducto)
    {
      return $this->__soapCall('getTiendas', array($idProducto));
    }

}
