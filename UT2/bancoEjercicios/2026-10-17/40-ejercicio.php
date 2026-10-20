<?php

declare(strict_types=1);
require_once __DIR__ . '/../2026-10-15/38-ejercicio.php';

usort(
    $coleccion, 
    fn(Libro $a, Libro $b): int => $a->paginas <=> $b->paginas
);

$totalPaginas = array_reduce(
    $coleccion,
    fn(int $carry, Libro $l)=> $carry + $l->paginas,
    0
);

$titulos = array_map(
    fn(Libro $l):string => $l->titulo,
    $coleccion
);

foreach($titulos as $clave => $valor){
    echo $clave . '<br>';
}
echo 'Total paginas: ' . $totalPaginas;

usort(
    $coleccion, 
    fn(Libro $a, Libro $b): int=> $b->paginas <=> $a->paginas
);

//Se renumeran las claves de la coleccion gracias a que el metodo 
// usort reindexa las clases automaticamente durante la ordenacion, pero 
//los ids se mantienen porque ya de por si son una propiedad del objeto, 
//no una clave que apunta al objeto dentro del array