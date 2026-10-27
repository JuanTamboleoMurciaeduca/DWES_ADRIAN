<?php

declare(strict_types=1);

$iva = 0.21;

$p = function(float $n) use ($iva): float {
    return $n * (1 + $iva);
};

$precioFinal = $p(100.0);
echo $precioFinal;