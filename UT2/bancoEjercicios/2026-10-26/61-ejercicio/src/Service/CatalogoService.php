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
    public function buscarDisponibles(string $texto, int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException(
                'El máximo de páginas debe ser mayor que cero.',
            );
        }

        $textoNormalizado = mb_strtolower(trim($texto), 'UTF-8');
        $resultado = array_values(array_filter(
            $this->repositorio->todos(),
            static function (Libro $libro) use ($textoNormalizado, $maximo): bool {
                $tituloNormalizado = mb_strtolower($libro->titulo(), 'UTF-8');

                return $libro->estaDisponible()
                    && str_contains($tituloNormalizado, $textoNormalizado)
                    && $libro->paginas() <= $maximo;
            },
        ));

        usort(
            $resultado,
            static fn (Libro $a, Libro $b): int => $a->paginas() <=> $b->paginas(),
        );

        return $resultado;
    }

    public function prestarPorId(int $id): void
    {
        $libro = $this->buscarLibro($id);
        $libro->prestar();
    }

    public function devolverPorId(int $id): void
    {
        $libro = $this->buscarLibro($id);
        $libro->devolver();
    }

    private function buscarLibro(int $id): Libro
    {
        $libro = $this->repositorio->buscarPorId($id);

        if ($libro === null) {
            throw new InvalidArgumentException('No existe un libro con id ' . $id . '.');
        }

        return $libro;
    }
}
