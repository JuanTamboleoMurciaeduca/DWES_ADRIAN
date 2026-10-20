<?php

declare(strict_types=1);
require_once __DIR__ . '/src/cargar.php';
require_once __DIR__ . '/src/datos.php';

$actividadesPrueba = crearActividades();

$actividad101 = array_find(
    $actividadesPrueba, 
    fn(Actividad $a): bool => $a->id() === 101
);
$actividad103 = array_find(
    $actividadesPrueba, 
    fn(Actividad $a): bool => $a->id() === 103
);

$importe = $actividad101->importe(2);
$importe2 = $actividad103->importe(2);

$responsable101 = $actividad101->responsable();
$responsable103 = $actividad103->responsable();

$responsable101 === $responsable103;

$responsable104 = array_find(
    $actividadesPrueba, 
    fn(Actividad $a): bool => $a->id() === 104)->responsable(); //null

print('Hola');