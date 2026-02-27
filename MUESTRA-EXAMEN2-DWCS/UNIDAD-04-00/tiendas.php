<?php
   if (!isset($_GET['id'])) { //si no mandamos el id volvemos a listado
    header('Location:listado.php');
   }

    $id = $_GET['id'];

    
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximumscale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css para usar Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
                        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
                        crossorigin="anonymous">
    <title>Tema 3</title>
</head>
<body style="background: #4dd0e1">
    <h3 class="text-center mt-2 font-weight-bold">Tiendas con oferta</h3>
    <div class="container mt-3">
        <a href="listado.php" class="btn btn-info">Volver</a>
        <table class="table table-striped table-dark">
            <thead>
                <tr class="text-center">
                    <th scope="col">Nombre</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Unidades disponibles en tienda</th>
                </tr>
            </thead>
            <tbody>
<?php
    require_once 'conexion.php';

    $consulta = "SELECT nombre, tlf, unidades  FROM tiendas, stocks WHERE tiendas.id = stocks.tienda AND stocks.producto = :i";

    $stmt = $conProyecto->prepare($consulta);

    try {
        $stmt->execute([':i' => $id]);
    } catch (PDOException $ex) {
        die("Error al recuperar la tienda: id producto no encontrado, mensaje de error: " . $ex->getMessage());
    }

    while ($filas = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo <<<MARCA
        <tr class='text-center'>
            <td>{$filas->nombre}</td>
            <td>{$filas->tlf}</td>
            <td>{$filas->unidades}</td>
        </tr>
MARCA;
    }
    $stmt = null;
    $conProyecto = null;
?>
            </tbody>
        </table>
    </div>
</body>
</html>