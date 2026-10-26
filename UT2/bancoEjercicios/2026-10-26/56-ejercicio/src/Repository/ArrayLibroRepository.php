<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\LibroRepository;
use App\Model\Libro;

final class ArrayLibroRepository implements LibroRepository
{
    /** @param Libro[] $libros */
    public function __construct(private array $libros)
    {
    }

    /** @return Libro[] */
    public function todos(): array
    {
        return $this->libros;
    }
}
