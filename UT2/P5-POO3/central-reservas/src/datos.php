<?php
declare(strict_types=1);

function crearActividades(): array
{
    $ana = new Responsable(1, 'Ana Torres');
    $bruno = new Responsable(2, 'Bruno Gil');
    return [
        new ActividadGratuita(101, 'Taller de cómic', 8, 3, EstadoActividad::Abierta, $ana),
        new ActividadPago(102, 'Fotografía nocturna', 6, 6, EstadoActividad::Abierta, $bruno, 1250),
        new ActividadPago(103, 'Creación de videojuegos', 10, 2, EstadoActividad::Abierta, $ana, 2000),
        new ActividadGratuita(104, 'Club de lectura', 5, 1, EstadoActividad::Cerrada, null),
        new ActividadPago(105, '  Órbita   creativa  ', 4, 0, EstadoActividad::Abierta, $bruno, 750),
    ];
}
