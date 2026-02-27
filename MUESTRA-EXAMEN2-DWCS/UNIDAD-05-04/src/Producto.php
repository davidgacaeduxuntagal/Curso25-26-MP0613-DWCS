<?php

namespace Clases;

use PDO;
use PDOException;

class Producto extends Conexion
{
    private $id;
    private $nombre;
    private $nombre_corto;
    private $pvp;
    private $familia;
    private $descripcion;

    public function __construct()
    {
        parent::__construct();
    }


    function recuperarProductos()
    {
        $consulta = "select * from productos order by nombre";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar productos: " . $ex->getMessage());
        }
        $this->conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    function consultarProducto($id)
    {
        $consulta = "select * from productos where id=:i";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error al recuperar Productos: " . $ex->getMessage());
        }
        //esta consulta solo devuelve una fila es innecesario el while para recorrerla
        $producto = $stmt->fetch(PDO::FETCH_OBJ);
        $stmt = null;
        return $producto;
    }
}

