<?php
declare(strict_types=1);

// Carga manual facilitada. El ejercicio no necesita Composer ni paquetes externos.
foreach ([
    'Contrato/Reservable.php', 'Modelo/EstadoActividad.php',
    'Compartido/GeneraEtiqueta.php', 'Modelo/Responsable.php',
    'Excepcion/ReservaException.php', 'Excepcion/PlazasInsuficientesException.php',
    'Modelo/Actividad.php', 'Modelo/ActividadGratuita.php', 'Modelo/ActividadPago.php'
] as $archivo) {
    require_once __DIR__ . '/' . $archivo;
}
