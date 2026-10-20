<?php
declare(strict_types=1);

// TODO M2. Declara EstadoActividad respaldado por string con los dos casos indicados.
enum EstadoActividad: string{
    case Abierta = 'abierta';
    case Cerrada = 'cerrada';
}