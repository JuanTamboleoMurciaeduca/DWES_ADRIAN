<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Exception\LibroNoDisponibleException;
use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

$dune = new Libro(10, 'Dune', true);
$libros = [
    $dune,
    new Libro(20, 'Solaris', false),
    new Libro(30, 'Drácula', true),
];
$servicio = new CatalogoService(new ArrayLibroRepository($libros));

foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

$servicio->prestarPorId(10);
foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

echo 'Dune disponible: ' . ($dune->estaDisponible() ? 'sí' : 'no') . PHP_EOL;

try {
    $servicio->prestarPorId(10);
} catch (LibroNoDisponibleException $excepcion) {
    echo $excepcion->getMessage() . PHP_EOL;
}

try {
    $servicio->prestarPorId(99);
} catch (InvalidArgumentException $excepcion) {
    echo $excepcion->getMessage() . PHP_EOL;
}

foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}
