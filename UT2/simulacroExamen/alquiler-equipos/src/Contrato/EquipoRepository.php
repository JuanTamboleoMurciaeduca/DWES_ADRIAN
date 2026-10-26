<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Contrato;

use Alquiler\Equipo\Modelo\Equipo;

interface EquipoRepository
{
    // TODO I1: declara las dos operaciones del repositorio.
    public function todos():array;
    public function buscarPorId(int $id): ?Equipo;
}
