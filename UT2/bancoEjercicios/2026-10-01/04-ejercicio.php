<?php

declare(strict_types=1);

require_once __DIR__ . '/datos.php';

$disponibles = array_filter(
    $libros, 
    fn (array $a):bool => $a['disponible'] === true
);

foreach($disponibles as $disponible){
    echo $disponible['titulo'];
}