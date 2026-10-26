<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Libro;

final class CatalogoService
{
    /** @param Libro[] $libros */
    public function __construct(private array $libros)
    {
    }

    /** @return string[] */
    public function fichas(): array
    {
        return array_map(
            static fn (Libro $libro): string => $libro->ficha(),
            $this->libros,
        );
    }
}
