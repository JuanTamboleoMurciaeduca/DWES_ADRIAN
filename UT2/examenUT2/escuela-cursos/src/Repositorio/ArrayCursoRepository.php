<?php

declare(strict_types=1);

namespace Escuela\Curso\Repositorio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Modelo\Curso;

final class ArrayCursoRepository implements CursoRepository
{
    private array $cursos = [];

    public function __construct(array $cursos)
    {
        foreach ($cursos as $curso) {
            if (isset($this->cursos[$curso->id()])) {
                throw new \InvalidArgumentException('Id duplicado');
            }

            $this->cursos[$curso->id()] = $curso;
        }
    }

    public function todos(): array
    {
        return array_values($this->cursos);
    }

    public function buscarPorId(int $id): ?Curso
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('Id no positivo');
        }

        return $this->cursos[$id] ?? null;
    }
}
