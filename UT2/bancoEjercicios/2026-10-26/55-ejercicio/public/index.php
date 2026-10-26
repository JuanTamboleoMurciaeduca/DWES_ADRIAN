<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Service\CatalogoService;

$servicio = new CatalogoService();

echo $servicio->mostrar(new Libro('Dune')) . PHP_EOL;
echo $servicio->mostrar(new Libro('Solaris')) . PHP_EOL;
