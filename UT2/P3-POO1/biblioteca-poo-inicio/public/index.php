<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autor.php';
require_once __DIR__ . '/../src/Categoria.php';
require_once __DIR__ . '/../src/Libro.php';
require_once __DIR__ . '/../src/datos.php';

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
$otro = $libros

$mensajes[] = 'Disponible: ' 
. ($dune->disponible ? 'true' : 'false');

// Lectura del formulario facilitada. La búsqueda conserva el texto escrito.
$entrada = $_GET['q'] ?? '';
$entradaBusqueda = is_string($entrada) ? $entrada : '';
$soloDisponibles = isset($_GET['disponibles']);
$ordenEntrada = $_GET['orden'] ?? 'paginas';
$orden = is_string($ordenEntrada)
    && in_array($ordenEntrada, ['paginas', 'titulo'], true)
    ? $ordenEntrada : 'paginas';

// Fase 6.1: normaliza la búsqueda y filtra con array_filter.
$busqueda = '';
$visibles = $libros;

// Fase 6.2: ordena $visibles mediante usort y <=>.

// Fase 6.3: resumen del catálogo completo, antes de filtrar.
// Completa disponibles con array_filter y paginas con array_reduce.
$resumen = ['total' => count($libros), 'disponibles' => 0, 'paginas' => 0];

// Fase 6.3: crea las fichas de los libros visibles con array_map.
$etiquetas = [];

// Fase 6.3: busca los ids 30 y 999 con array_find y añade mensajes.

require __DIR__ . '/../vista/catalogo.php';
