<?php
// --------------------------------------------------------------------
//  Funciones auxiliares
// --------------------------------------------------------------------
function esPrimo($numero)
{
    if ($numero <= 1) {
        return false;
    }

    if ($numero === 2) {
        return true;
    }

    // Nos evitamos procesar todos los pares mayores de 2
    if ($numero % 2 === 0) {
        return false;
    }

    // Ejemplo de optimización: solo comprobamos hasta la raíz cuadrada del número y solo los impares
    //  $i <= sqrt($numero) es equivalente a $i * $i <= $numero, pero esta última evita cálculos de raíz cuadrada
    for ($i = 3; $i * $i <= $numero; $i += 2) {
        if ($numero % $i === 0) {
            return false;
        }
    }

    return true;
}


function formatoNumero($n)
{
    return str_replace(' ', '&nbsp;', sprintf('%3d', $n));
}


function pintarTabla($elementos, $posiciones, $numero)
{
    // Calcular el número de columnas para que la tabla sea lo más cuadrada posible
    $columnas = max(1, (int) floor(sqrt($numero)));

    echo "<table bposiciones='1' cellpadding='4' cellspacing='0'>";
    for ($i = 0; $i < count($posiciones); $i++) {
        if ($i % $columnas === 0) {
            echo "<tr>";
        }

        $id    = $posiciones[$i];
        $valor = $elementos[$id];
        $color = '#ffffff';

        if (esPrimo($valor)) {
            $color = '#ff6666';
        }

        echo "<td style='text-align:right; font-family:monospace;'>";
        // Como en el apartado 3 nos piden que al hacer clic en la celda hacer algo, usamos
        //  un button pero sin ninguna acción por ahora
        echo "<button type='button' name='celda' value='" 
           . $id 
           . "' style='background-color:" 
           . $color 
           . "; min-width:52px; text-align:right;'>" 
           . formatoNumero($valor) 
           . "</button>";
        echo "</td>";

        if ($i % $columnas === $columnas - 1 || $i === count($posiciones) - 1) {
            echo "</tr>";
        }
    }
    echo "</table><br>";
}
?>


<?php
$numero        = isset($_GET['numero']) ? (int) $_GET['numero'] : "";
$error         = '';
$elementos     = [];   // Guarda los elementos generados aleatoriamente
$posiciones    = [];   // Guarda la posición secuencial, dentro de la tabla, de cada elemento de $elementos


if (!isset($_GET['reset'])) {
    // ------------------------------------------------------------------------ 
    // Recuperar el estado actual de los elementos, posiciones guardados en campos hidden del formulario
    // ------------------------------------------------------------------------
    if (isset($_GET['elementos']) && is_array($_GET['elementos'])) {
        foreach ($_GET['elementos'] as $id => $value) {
            $id    = (int) $id;
            $value = (int) $value;
            if ($value >= 1 && $value <= 999) {
                $elementos[$id] = $value;
            }
        }
    }

    if (isset($_GET['posiciones']) && is_array($_GET['posiciones'])) {
        foreach ($_GET['posiciones'] as $id) {
            $id = (int) $id;
            if (array_key_exists($id, $elementos)) {
                $posiciones[] = $id;
            }
        }
    }

    // Guarda numero por si hacen clic en reordenar poder
    //  restaurar el número correcto
    $numeroAnterior = isset($_GET['numeroAnterior']) ? (int) $_GET['numeroAnterior'] : 0;
  

    // ------------------------------------------------------------------------ 
    // Procesar recepción del formulario
    // ------------------------------------------------------------------------

    // Si se ha enviado el formulario para generar nuevos elementos, procesar la generación
    if (isset($_GET['enviar'])) {
        if ($numero < 10 || $numero > 100) {
            $error         = 'El valor debe estar entre 10 y 100';
            $elementos     = [];
            $posiciones    = [];
        } else {
            $elementos = [];
            for ($i = 0; $i < $numero; $i++) {
                $elementos[$i] = rand(1, 999);
            }
            $posiciones    = array_keys($elementos);
        }
    } else {
        // Restaurar el número anterior para que no cambie al hacer clic en reordenar o en un número
        $numero = $numeroAnterior;
        
        if (isset($_GET['reordenar']) && !empty($posiciones)) {
            shuffle($posiciones);
        }
    }
} else {
    header("Location: " . $_SERVER['PHP_SELF']);
    // Otra forma de evitar que se reenvíen los datos al refrescar la página después de resetear:
    // echo '<script>history.replaceState({}, "", "' . $_SERVER['PHP_SELF'] . '");</script>';
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo solución examen UT2</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">

        <?php 
        // --------------------------------------------------------------------
        // Guardar el estado actual 
        // --------------------------------------------------------------------
        ?>
        <?php foreach ($elementos as $id => $valor): ?>
            <input type="hidden" name="elementos[<?= $id ?>]" value="<?= $valor ?>">
        <?php endforeach; ?>

        <?php foreach ($posiciones as $id): ?>
            <input type="hidden" name="posiciones[]" value="<?= $id ?>">
        <?php endforeach; ?>
        
        <!-- Guardar el número anterior por si hacen clic en reordenar habiendo cambiado el campo de numero-->
        <input type="hidden" name="numeroAnterior" value="<?= $numero ?>">

        <?php    
        // --------------------------------------------------------------------
        // Generar respuesta 
        // --------------------------------------------------------------------     
        ?>
        <div>
            <label for="numero">Introduzca el número de elementos a generar (10 - 100):</label>
            <input type="text" name='numero' value='<?= $numero ?>'>
        </div>

        <?php
        if ($error !== '') {
            echo "<p>" . $error . "</p>";
        }

        if (!empty($elementos)) {
            pintarTabla($elementos, $posiciones, $numero);
        }
        ?>

        <button type='submit' name='enviar'>Enviar</button>
        <button type='submit' name='reset'>Reset</button>
        <?php if (!empty($elementos)) { ?>
            <button type='submit' name='reordenar'>Reordenar</button>
        <?php } ?>
    </form>
</body>

</html>