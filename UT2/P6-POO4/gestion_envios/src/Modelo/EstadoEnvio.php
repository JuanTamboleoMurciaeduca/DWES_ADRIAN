<?php

declare(strict_types=1);

namespace App\Modelo;

enum EstadoEnvio:string
{
    case Pendiente = 'pendiente';
    case Enviado = 'enviado';
    case Entregado = 'entregado';
    case Cancelado = 'cancelado';
}
