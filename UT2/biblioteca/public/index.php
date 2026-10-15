<?php
use App\Model\Libro;
use App\Importacion\Libro as LibroImportado;
use Ramsey\Uuid\Uuid;
require_once __DIR__ . '/../vendor/autoload.php';
$libro = new Libro('Dune');
$importado = new LibroImportado('El Hobbit');
$id = Uuid::uuid4()->toString();
echo $libro->titulo() . PHP_EOL;
echo $importado->titulo() . PHP_EOL;
echo 'UUID generado: ' . $id . PHP_EOL;