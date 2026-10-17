<?php

declare(strict_types=1);
require_once __DIR__ . '/../2026-10-15/38-ejercicio.php';

$busqueda = mb_strtolower(trim('   DRÁ   '), 'UTF-8');


$librosFiltrados = array_filter(
    $coleccion,
    fn(Libro $l):bool => str_contains( mb_strtolower(trim($l->titulo),'UTF-8') , $busqueda)
);

$etiquetas = array_map(
    fn(Libro $l): string => ($l->titulo . ' - ' . $l->paginas . ' páginas'), 
    $librosFiltrados
);

if(empty($librosFiltrados)){
    echo 'Sin resultados';
}
foreach($etiquetas as $clave => $valor){
    echo $valor;
    echo '<br>';
}