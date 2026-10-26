<?php

declare(strict_types=1);

namespace App\Model;

final class Libro
{
    public function __construct(
        private int $id,
        private string $titulo,
        private bool $disponibilidad,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function estaDisponible(): bool
    {
        return $this->disponibilidad;
    }
}
