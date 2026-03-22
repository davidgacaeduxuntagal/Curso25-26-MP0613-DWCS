<?php


namespace Clases;

require '../vendor/autoload.php';


use Clases\Tienda;

class OperacionesExamen2
{
    /**
     * Obtiene listado de tiendas en formato {nombre, telefono, unidades} 
     * @soap
     * @param int $idProducto  
     * @return array de objetos de tipo Tienda
     */
    public function getTiendas($idProducto)
    {
        $tienda = new Tienda();
        $tiendas = $tienda->buscarTiendas($idProducto);
        $tienda = null;

        return $tiendas;
    }
}
