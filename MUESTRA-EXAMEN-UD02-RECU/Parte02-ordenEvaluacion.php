<?php
// Poner breaks entre cada bloque de código para que se vea el resultado de cada bloque por separado
// 1) 
$a = 1_000.34 + 1_000.10;
$b = 0xFE + 1;
$c = $r16 = 0b001 + 0b001;
$d = 0333 + 0001;

echo "Terminado 1" . PHP_EOL;

// 2)
$a = 3 ** 2 ** 3;
$b = 15 - 3 ** 4 / 3;
// $c = 10/-0;
// $d = -10 / -0;

echo "Terminado 2" . PHP_EOL;

// 3)
$a5 = 1;
$b5 = 2;
$r5 = $a5 * $b5 >= 2 ? $a5 += $b5-- : $a5 /= --$b5;

echo "Terminado 3" . PHP_EOL;