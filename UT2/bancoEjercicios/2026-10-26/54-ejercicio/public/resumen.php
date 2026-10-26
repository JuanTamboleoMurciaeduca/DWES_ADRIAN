<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Model\Revista;

$recursos = [new Libro('Dune'), new Revista('Ciencia')];

echo 'Total de recursos: ' . count($recursos) . PHP_EOL;
foreach ($recursos as $recurso) {
    echo $recurso->tipo() . PHP_EOL;
}
