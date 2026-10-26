<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Repositorio;

use Alquiler\Equipo\Contrato\EquipoRepository;
use Alquiler\Equipo\Modelo\Equipo;

final class ArrayEquipoRepository implements EquipoRepository
{
    private array $equipos = [];

    public function __construct(array $equipos)
    {
        foreach ($equipos as $equipo) {
            if (isset($this->equipos[$equipo->id()])) {
                throw new \InvalidArgumentException('Id duplicado');
            }

            $this->equipos[$equipo->id()] = $equipo;
        }
    }

    public function todos(): array
    {
        return array_values($this->equipos);
    }

    public function buscarPorId(int $id): ?Equipo
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Id no positivo');
        }

        return $this->equipos[$id] ?? null;
    }
}
