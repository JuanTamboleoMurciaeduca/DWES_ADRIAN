<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Modelo;

final class EquipoSonido extends Equipo
{
    public function tipo(): string
    {
        return 'sonido';
    }

    public function tarifaDia(): int
    {
        // TODO M2: calcula la tarifa diaria de sonido.
        return $this->tarifaBaseCentimos;
    }
}
