<?php
declare(strict_types=1);

require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';
require_once __DIR__ . '/Libro.php';

// Fase 2.1: crea aquí un Autor y una Categoria y muestra sus nombres.
$autor = new Autor('Frank Herbert');
$categoria = new Categoria('Ciencia ficcion');

echo $autor->nombre . PHP_EOL;
echo $categoria->nombre . PHP_EOL;
// Fase 2.2: cuando completes Libro.php, añade su require_once arriba.
// Después crea los dos libros y muestra su disponibilidad.

// $libro1 = new Libro(10, 'Dune', 412, $autor, $categoria);
// echo $libro1->disponible ? 'True' . PHP_EOL : 'False' . PHP_EOL;

// $libro2 = new Libro(10, 'Dune', 412, $autor, $categoria, false);
// echo $libro2->disponible ? 'True' . PHP_EOL : 'False' . PHP_EOL;

// Fase 3.2: sustituye las pruebas anteriores por un Libro construido
// con las variables $titulo y $paginas. Muestra ambas propiedades.

$titulo = '  ';
$paginas = 0;

$libro = new Libro(10, $titulo, $paginas, $autor, $categoria);

echo 'Titulo: ' . $libro->titulo . '. Paginas: ' . $libro->paginas . '.' . PHP_EOL;