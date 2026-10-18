<?php

declare(strict_types=1);

require_once __DIR__ . '/../2026-10-15/38-ejercicio.php';

$disponibles = array_filter(
    $coleccion, 
    fn(Libro $l):bool => $l->disponible === true
);

$libroConId10 = array_find(
    $coleccion, 
    fn(Libro $l):bool => $l->id === 10
);

if(isset($libroConId10)){
    $libroConId10->prestar();
}

echo $libroConId10->disponible ? 'True' : 'False';
echo '<br>';
echo $coleccion[0]->disponible ? 'True' : 'False';
echo '<br>';
echo $disponibles[0]->disponible ? 'True' : 'False';
echo '<br>';

$disponibles2 = array_filter(
    $coleccion, 
    fn(Libro $l):bool => $l->disponible === true
);

$libroConId99 = array_find(
    $coleccion, 
    fn(Libro $l):bool => $l->id === 99
);

echo $libroConId99?->titulo ?? 'Libro no encontrado';

//Las colecciones contienen referencias al mismo objeto porque estas guardan todas
//la misma dirección en memoria, es decir, el objeto creado
//Si inicialmente hemos guardado un objeto en una variable, aunque cambie el estado del 
//objeto va a seguir dentro de la misma variable. Estamos modificando un objeto concreto, no la clase
