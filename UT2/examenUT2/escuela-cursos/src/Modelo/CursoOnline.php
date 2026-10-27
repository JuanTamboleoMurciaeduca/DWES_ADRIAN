<?php

declare(strict_types=1);

namespace Escuela\Curso\Modelo;

final class CursoOnline extends Curso
{
    public function tipo(): string
    {
        return 'online';
    }

    public function precioPlaza(): int
    {
        // TODO M2: calcula el precio de una plaza online.
        return $this->precioBaseCentimos;
    }
}
