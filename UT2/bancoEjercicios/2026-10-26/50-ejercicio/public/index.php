<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Model/Autor.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Importacion/Libro.php';

use App\Importacion\Libro as LibroImportado;
use App\Model\Autor;
use App\Model\Libro;

$autor = new Autor('Frank Herbert');
$libro = new Libro('Dune', $autor);
$libroImportado = new LibroImportado('El Hobbit');

echo $libro->ficha() . PHP_EOL;
echo $libroImportado->titulo() . PHP_EOL;
