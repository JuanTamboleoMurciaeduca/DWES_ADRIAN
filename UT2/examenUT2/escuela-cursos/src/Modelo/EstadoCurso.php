<?php

declare(strict_types=1);

namespace Escuela\Curso\Modelo;

enum EstadoCurso: string
{
    // TODO E1: declara los casos del estado de un curso.
    case Abierto = 'abierto';
    case Cerrado = 'cerrado';
}
