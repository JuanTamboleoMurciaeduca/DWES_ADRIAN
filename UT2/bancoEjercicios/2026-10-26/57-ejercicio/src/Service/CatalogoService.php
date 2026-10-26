<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;
use InvalidArgumentException;

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

    public function prestarPorId(int $id): void
    {
        $libro = $this->repositorio->buscarPorId($id);
        if ($libro === null) {
            throw new InvalidArgumentException('No existe un libro con id ' . $id);
        }

        $libro->prestar();
    }
}
