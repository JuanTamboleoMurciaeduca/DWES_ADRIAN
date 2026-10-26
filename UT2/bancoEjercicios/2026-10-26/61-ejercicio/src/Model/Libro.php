<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\LibroNoDisponibleException;
use InvalidArgumentException;

final class Libro
{
    public function __construct(
        private int $id,
        private string $titulo,
        private int $paginas,
        private bool $disponible,
    ) {
        $titulo = trim($this->titulo);

        if ($this->id <= 0) {
            throw new InvalidArgumentException('El id debe ser mayor que cero.');
        }

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        if ($this->paginas <= 0) {
            throw new InvalidArgumentException('El número de páginas debe ser mayor que cero.');
        }

        $this->titulo = $titulo;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException(
                'El libro no está disponible: ' . $this->titulo,
            );
        }

        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}
