<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Model\Revista;
use App\Service\ListadoService;

$servicio = new ListadoService();
$recursos = [new Libro('Dune'), new Revista('Ciencia')];

foreach ($servicio->lineas($recursos) as $linea) {
    echo $linea . PHP_EOL;
}

$recursos[] = new Revista('Historia');
foreach ($servicio->lineas($recursos) as $linea) {
    echo $linea . PHP_EOL;
}
