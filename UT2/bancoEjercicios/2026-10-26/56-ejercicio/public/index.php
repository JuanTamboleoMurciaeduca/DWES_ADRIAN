<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

$libros = [
    new Libro(10, 'Dune', true),
    new Libro(20, 'Solaris', false),
    new Libro(30, 'Drácula', true),
];
$servicio = new CatalogoService(new ArrayLibroRepository($libros));

foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

$servicioVacio = new CatalogoService(new ArrayLibroRepository([]));
if ($servicioVacio->titulosDisponibles() === []) {
    echo 'Sin libros disponibles' . PHP_EOL;
}
