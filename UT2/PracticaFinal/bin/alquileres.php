<?php

declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

use Clase\Alquileres\Modelo\Alquiler;
use Clase\Alquileres\Excepcion\AlquilerException;
use Clase\Alquileres\Modelo\AlquilerBicicleta;
use Clase\Alquileres\Modelo\AlquilerPatinete;
use Clase\Alquileres\Modelo\EstadoAlquiler;
use Clase\Alquileres\Servicio\ServicioAlquileres;
use InvalidArgumentException;

$alquileres = [
    new AlquilerBicicleta(501, 'Lucía Torres', 2, EstadoAlquiler::Reservado),
    new AlquilerPatinete(502, 'Álex Ruiz', 2, EstadoAlquiler::Activo),
    new AlquilerBicicleta(503, 'Óscar Gil', 3, EstadoAlquiler::Finalizado),
    new AlquilerPatinete(504, 'Lucía Molina', 1, EstadoAlquiler::Reservado)
];

$servicio = new ServicioAlquileres($alquileres);

function mostrar(
    string $titulo,
    array $alquileres,
    ServicioAlquileres $servicio
): void {
    echo $titulo . PHP_EOL;
    if ($alquileres === []) {
        echo 'Sin resultados' . PHP_EOL;
    }
    foreach ($alquileres as $a) {
        echo $a->id() . ' | ' . $a->cliente() . ' | ' . $a->modalidad()
            . ' | días: ' . $a->dias() . ' | ' . $a->estado()->value
            . ' | ' . $a->importe() . ' céntimos' . PHP_EOL;
    }
    $resumen = $servicio->resumir($alquileres);
    echo 'Cantidad: ' . $resumen['cantidad']
        . ' | Importe: ' . $resumen['importe'] . ' céntimos'
        . PHP_EOL . PHP_EOL;
}
//Mostrar coleccion inicial
mostrar('======= Mostrar Informacion de alquileres ======', $alquileres, $servicio);

//Sin filtros


mostrar('======= Mostrar Informacion de alquileres ======', $servicio->consultar(), $servicio);

// Texto ' LUCÍA '

mostrar('======= Mostrar Informacion de alquileres ======', $servicio->consultar(' LUCÍA '), $servicio);

// Alquileres activos sin filtrar por nombre

mostrar('======= Mostrar Informacion de alquileres ======', $servicio->consultar('', EstadoAlquiler::Activo), $servicio);


// 'MOLINA' entre los alquileres reservados

mostrar('======= Mostrar Informacion de alquileres ======', $servicio->consultar('MOLINA', EstadoAlquiler::Reservado), $servicio);

// 'ÓSCAR' entre los alquileres reservados

mostrar('======= Mostrar Informacion de alquileres ======', $servicio->consultar('ÓSCAR', EstadoAlquiler::Reservado), $servicio);



//Paso 1
$alquileres[0]->iniciar();
//Paso 2
try {
    $alquileres[0]->iniciar();
} catch (AlquilerException $e) {
    echo $e->getMessage() . "\n";
}

//Paso 3

$alquileres[0]->finalizar();

//Paso 4

try{
    $alquileres[2]->iniciar();
}catch(AlquilerException $e){
    echo $e->getMessage() . "\n";

}

//Paso 5

try{
    $alquileres[3]->finalizar();
}catch(AlquilerException $e){
    echo $e->getMessage() . "\n";

}

//Paso 6
$alquileres[1]->finalizar();
//Paso 7
$alquileres[3]->iniciar();

mostrar('Activos al terminar', $servicio->consultar('', EstadoAlquiler::Activo), $servicio);
mostrar('Reservados', $servicio->consultar('', EstadoAlquiler::Reservado), $servicio);
mostrar('Coleccion final', $servicio->consultar(), $servicio);


//Prueba id 0

try {
    $prueba1 = new AlquilerBicicleta(0, 'fulanito', 6, EstadoAlquiler::Reservado);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}

//Prueba cliente vacio

try {
    $prueba2 = new AlquilerBicicleta(1, '', 6, EstadoAlquiler::Reservado);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}

// Prueba cliente solo espacios


try {
    $prueba3 = new AlquilerBicicleta(1, '    ', 6, EstadoAlquiler::Reservado);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}

//Duraciones 0 y 8

try {
    $prueba4 = new AlquilerBicicleta(1, 'fulanito', 0, EstadoAlquiler::Reservado);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}

try {
    $prueba5 = new AlquilerBicicleta(1, 'fulanito', 8, EstadoAlquiler::Reservado);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . "\n";
}

$cliente1 = new AlquilerBicicleta(5, '  Jose  ', 6, EstadoAlquiler::Activo);
$alquileres[] = $cliente1;

mostrar('', $alquileres, $servicio);

// 4.4.3
//Hago una operacion que se que va a salir mal
try{
    $alquileres[2]->iniciar();
}catch(AlquilerException $e){
    echo $e->getMessage() . "\n";

}

//Muestro el estado despues

mostrar('Estado despues de operacion mala', $alquileres, $servicio);


//Otro caso con finalizar
try{
    $alquileres[3]->finalizar();
    $alquileres[3]->finalizar();
}catch(AlquilerException $e){
    echo $e->getMessage() . "\n";

}
mostrar('Estado despues de operacion mala', $alquileres, $servicio);
