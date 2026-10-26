<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;

final class CatalogoService
{
    public function __construct(private LibroRepository $repositorio)
    {
    }

    /** @return Libro[] */
    public function disponibles(): array
    {
        return array_values(array_filter(
            $this->repositorio->todos(),
            static fn (Libro $libro): bool => $libro->estaDisponible(),
        ));
    }

    /** @return string[] */
    public function titulosDisponibles(): array
    {
        return array_map(
            static fn (Libro $libro): string => $libro->titulo(),
            $this->disponibles(),
        );
    }
}
