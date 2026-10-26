<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\LibroNoDisponibleException;

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

    public function prestar(): void
    {
        if (!$this->disponibilidad) {
            throw new LibroNoDisponibleException('El libro no está disponible: ' . $this->titulo);
        }

        $this->disponibilidad = false;
    }

    public function devolver(): void
    {
        $this->disponibilidad = true;
    }
}
