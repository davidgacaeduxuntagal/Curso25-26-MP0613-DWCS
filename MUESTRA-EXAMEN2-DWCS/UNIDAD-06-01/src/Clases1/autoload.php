<?php


 function autoload_6c8029cb578635e22357887290a8849f($class)
{
    $classes = array(
        'Clases\Clases1\ClasesOperacionesExamen2Service' => __DIR__ .'/ClasesOperacionesExamen2Service.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_6c8029cb578635e22357887290a8849f');

// Do nothing. The rest is just leftovers from the code generation.
{
}
