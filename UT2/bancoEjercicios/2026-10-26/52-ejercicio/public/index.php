<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Model\Personas\Autor;
use App\Service\CatalogoService;

$catalogo = new CatalogoService([
    new Libro('Dune', new Autor('Frank Herbert')),
    new Libro('Solaris', new Autor('Stanislaw Lem')),
]);

foreach ($catalogo->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}

$catalogoVacio = new CatalogoService([]);
foreach ($catalogoVacio->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}
