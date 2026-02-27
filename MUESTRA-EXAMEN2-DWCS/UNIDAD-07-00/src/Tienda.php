<?php

namespace Clases;

use PDO;
use PDOException;

class Tienda extends Conexion
{
    private $id;
    private $nombre;
    private $telefono;

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarTiendas($idProducto)
    {
        $consulta = "select t.nombre, t.tlf, s.unidades from tiendas as t join stocks as s join productos as p 
                 where t.id = s.tienda and s.producto = p.id and p.id = :id";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([
                ':id' => $idProducto
            ]);
        } catch (PDOException $ex) {
            die("Error al consultar listado tiendas: " . $ex->getMessage());
        }

        $this->conexion = null;
        
        if ($stmt->rowCount() == 0) return null;
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $tiendas[] = $fila;
        }

        return $tiendas;
    }
}
