<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Importacion\Libro as LibroImportado;
use App\Model\Autor;
use App\Model\Categoria;
use App\Model\Libro;

$autor = new Autor('Frank Herbert');
$libro = new Libro('Dune', $autor);
$libroImportado = new LibroImportado('El Hobbit');
$categoria = new Categoria('Ciencia ficción');

echo $libro->ficha() . PHP_EOL;
echo $libroImportado->titulo() . PHP_EOL;
echo $categoria->nombre() . PHP_EOL;
