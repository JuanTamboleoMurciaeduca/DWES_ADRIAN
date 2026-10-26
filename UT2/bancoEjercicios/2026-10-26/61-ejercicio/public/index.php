<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Exception\LibroNoDisponibleException;
use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

/**
 * @param Libro[] $libros
 */
function mostrarResultados(array $libros): void
{
    if ($libros === []) {
        echo 'Sin resultados' . PHP_EOL;

        return;
    }

    foreach ($libros as $libro) {
        echo $libro->titulo() . PHP_EOL;
    }
}

$libros = [
    new Libro(10, 'Dune', 412, true),
    new Libro(20, 'Solaris', 216, false),
    new Libro(30, 'Drácula', 418, true),
    new Libro(40, 'El Hobbit', 310, true),
];

$servicio = new CatalogoService(new ArrayLibroRepository($libros));

mostrarResultados($servicio->buscarDisponibles('', 500));
mostrarResultados($servicio->buscarDisponibles('  DRÁ  ', 500));
mostrarResultados($servicio->buscarDisponibles('xyz', 500));

$servicio->prestarPorId(10);

try {
    $servicio->prestarPorId(10);
} catch (LibroNoDisponibleException $excepcion) {
    echo $excepcion->getMessage() . PHP_EOL;
}

mostrarResultados($servicio->buscarDisponibles('', 500));

$servicio->devolverPorId(10);
mostrarResultados($servicio->buscarDisponibles('', 500));

try {
    $servicio->prestarPorId(99);
} catch (InvalidArgumentException $excepcion) {
    echo $excepcion->getMessage() . PHP_EOL;
}

try {
    $servicio->buscarDisponibles('', 0);
} catch (InvalidArgumentException $excepcion) {
    echo $excepcion->getMessage() . PHP_EOL;
}
