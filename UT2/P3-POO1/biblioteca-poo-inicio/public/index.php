<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autor.php';
require_once __DIR__ . '/../src/Categoria.php';
require_once __DIR__ . '/../src/Libro.php';
require_once __DIR__ . '/../src/datos.php';

$libros = [];
// Fase 4: convierte los registros de $datos en objetos Libro.
foreach ($datos as $registro) {
    $autor = $registro['autor'] === null
        ? null : new Autor($registro['autor']);
    $categoria = new Categoria($registro['categoria']);
    $libros[] = new Libro(
        // Datos del registro, objeto Autor o null y Categoria. 
        $registro['id'], $registro['titulo'], $registro['paginas'], $autor, $categoria, $registro['disponible']
    );
}

// Fase 5: realiza aquí las comprobaciones de préstamos e identidad.
// Añade textos a $mensajes; la vista los mostrará debajo del catálogo.
// Termina devolviendo Dune para conservar el estado inicial del catálogo.
$mensajes = [];

$dune = $libros[0];
$otro = array_find($libros, fn(Libro $libro): bool => $libro->titulo === '1984');

$mensajes[] = 'Dune al inicio: ' . ($dune->disponible ? 'True' : 'False');

$mensajes[] = '1984 al inicio: ' . ($otro->disponible ? 'true' : 'false');

$dune->prestar();

$mensajes[] = 'Dune después de prestar(): ' . ($dune->disponible ? 'true' : 'false');
$mensajes[] = '1984 después de prestar Dune: ' . ($otro->disponible ? 'true' : 'false');

$dune->devolver();

$mensajes[] = 'Dune después de devolver(): ' . ($dune->disponible ? 'true' : 'false');

$mensajes[] = 'Ficha de Dune: ' . $dune->ficha();

$solaris = $libros[3];
$mensajes[] = 'Ficha de Solaris: ' . $solaris->ficha();



$alias = $dune;

$alias->prestar();

$mensajes[] = 'Dune después de prestar el alias: ' . ($dune->disponible ? 'true' : 'false');

$mensajes[] = 'El alias y Dune son el mismo objeto: ' . ($alias === $dune ? 'true' : 'false');

$dune2 = new Libro(10, 'Dune', 412, $dune->autor, $dune->categoria);

$mensajes[] = 'La nueva instancia y Dune son el mismo objeto: ' . ($dune === $dune2 ? 'true' : 'false');

$dune->devolver();

$mensajes[] = 'Dune al terminar la simulación: ' . ($dune->disponible ? 'true' : 'false');


// Lectura del formulario facilitada. La búsqueda conserva el texto escrito.
$entrada = $_GET['q'] ?? '';
$entradaBusqueda = is_string($entrada) ? $entrada : '';
$soloDisponibles = isset($_GET['disponibles']);
$ordenEntrada = $_GET['orden'] ?? 'paginas';
$orden = is_string($ordenEntrada)
    && in_array($ordenEntrada, ['paginas', 'titulo'], true)
    ? $ordenEntrada : 'paginas';

// Fase 6.1: normaliza la búsqueda y filtra con array_filter.
$busqueda = mb_strtolower(trim($entradaBusqueda), 'UTF-8');
$visibles = array_filter($libros, 
                        fn(Libro $libro): bool=>
                        (str_contains(mb_strtolower(trim($libro->titulo), 'UTF-8'), $busqueda)) &&
                        (!$soloDisponibles || $libro->disponible === true));

// Fase 6.2: ordena $visibles mediante usort y <=>.

usort($visibles, 
        fn(Libro $a, Libro $b):int =>
           $orden === 'titulo' ? $a->titulo <=> $b-> titulo : $a->paginas <=> $b->paginas);

// Fase 6.3: resumen del catálogo completo, antes de filtrar.
// Completa disponibles con array_filter y paginas con array_reduce.
$resumen = ['total' => count($libros), 
            'disponibles' => count(array_filter($libros, fn(Libro $libro):bool => $libro->disponible === true)), 
            'paginas' => array_reduce($libros, fn(int $carry, Libro $libro): int=> $carry + $libro->paginas, 0)];


// Fase 6.3: crea las fichas de los libros visibles con array_map.
$etiquetas = array_map(
    fn(Libro $libro):string => $libro->ficha(),
    $visibles
);

// Fase 6.3: busca los ids 30 y 999 con array_find y añade mensajes.

$libroRequerido = array_find(
    $libros,
    fn(Libro $libro):bool => $libro->id === 30
);

$mensajes[] = 'Buscar id 30: ' . ($libroRequerido?->titulo ?? 'Libro no encontrado');

$libroRequerido2 = array_find(
    $libros, 
    fn(Libro $libro): bool=> $libro->id === 999
);

$mensajes[] = 'Buscar id 999: ' . ($libroRequerido2?->titulo ?? 'Libro no encontrado');

require __DIR__ . '/../vista/catalogo.php';
