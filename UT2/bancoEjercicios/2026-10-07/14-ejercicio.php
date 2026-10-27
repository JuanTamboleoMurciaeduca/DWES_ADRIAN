<?php

//Ordena una colección de libros por número de páginas de menor a mayor usando usort
// y el operador <=>. Después invierte el criterio para obtener orden descendente. 
//Comprueba qué ocurre con las claves

declare(strict_types=1);

require_once __DIR__ . '/datos.php';
//No es necesario guardarlo en una variable, pero lo hago para 
//tenerlo mas a mano en este fichero

//Orden ascendente
usort(
    $libros,
    fn(array $a, array $b): int =>
    $a['paginas'] <=> $b['paginas']
);

//comprobacion para ver que ocurre con las claves:
foreach ($libros as $clave => $libro) {
    echo $clave . ': ' . $libro['paginas'];
    echo '<br>';
}
//Las claves se han mantenido en su posicion natural, pero los valores
//han cambiado

//Orden descendente

usort(
    $libros,
    fn(array $a, array $b): int =>
    $b['paginas'] <=> $a['paginas']
);

foreach ($libros as $clave => $libro) {
    echo $clave . ': ' . $libro['paginas'];
    echo '<br>';
}
