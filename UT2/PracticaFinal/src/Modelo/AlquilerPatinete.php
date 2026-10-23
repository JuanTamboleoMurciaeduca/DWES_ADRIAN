<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;

class AlquilerPatinete extends Alquiler
{
    // No hace falta volver a definir el constructor, por defecto coge el del padre

    public function modalidad(): string
    {
        return 'patinete';
    }

    protected function tarifaDiaria(): int
    {
        return 1000;
    }
}
