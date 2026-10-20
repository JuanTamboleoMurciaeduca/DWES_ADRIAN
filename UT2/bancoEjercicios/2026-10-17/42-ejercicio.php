<?php

declare(strict_types=1);

require_once __DIR__ . '/../2026-10-15/38-ejercicio.php';

function seleccionarDesdeEntrada(array $libros, mixed $entrada):array{
    $entradaValida = is_string($entrada) ? filter_var($entrada, FILTER_VALIDATE_INT) : null;
    if (!$entradaValida || $entradaValida < 1){
        return [];
    }else{
        $objetosDisponibles = array_filter(
            $libros, 
            fn(Libro $l):bool => ($l->disponible === true) && ($l->paginas <= $entrada)
        );
        $titulos = array_map(
            fn(Libro $l):string => $l->titulo,
            $objetosDisponibles
        );
        $existeLibroMayor400pags = array_any(
            $objetosDisponibles,
            fn(Libro $l):bool => $l->paginas > 400
        );
        $todosTienenPaginasPositivas = array_all(
            $objetosDisponibles,
            fn(Libro $l):bool => $l->paginas > 0
        );

        foreach($titulos as $clave => $valor){
            echo $valor . '<br>';
        }
        
        if($existeLibroMayor400pags){
            $libroMayor400pags = array_find(
                $objetosDisponibles,
                fn(Libro $l):bool => $l->paginas > 400
            );
            echo $libroMayor400pags->titulo;
            echo '<br>';
        }else{
            echo 'Sin coincidencias';
            echo '<br>';
        }

        echo $todosTienenPaginasPositivas ? 'Todos tienen paginas positivas' : 'Sin coincidencias';
    }
    return $objetosDisponibles;
}

seleccionarDesdeEntrada($coleccion, '500');
// seleccionarDesdeEntrada($coleccion, '0');
// seleccionarDesdeEntrada($coleccion, 'abc');
// seleccionarDesdeEntrada($coleccion, ['500']);
// seleccionarDesdeEntrada($coleccion, '100');

// Convertir directamente con (int) no sirve para validar porque 
// Si una entrada no es posible convertirla a int, la aplicacion falla 
// y se detiene completamente, pero validando correctamente damos lugar a gestionar
// la situacion segun corresponda