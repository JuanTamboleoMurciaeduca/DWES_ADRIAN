<?php

declare(strict_types=1);

namespace App\Model;

final class Libro
{
    public function __construct(
        private string $titulo,
        private Autor $autor,
    ) {
    }

    public function ficha(): string
    {
        return $this->titulo . ' - ' . $this->autor->nombre();
    }
}
