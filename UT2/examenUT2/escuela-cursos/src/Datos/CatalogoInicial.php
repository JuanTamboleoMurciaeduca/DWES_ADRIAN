<?php

declare(strict_types=1);

namespace Escuela\Curso\Datos;

use Escuela\Curso\Modelo\{CursoOnline, CursoPresencial, EstadoCurso};

final class CatalogoInicial
{
    public function cursos(): array
    {
        return [
            new CursoPresencial(201, 'Fotografía móvil', 8, 3, EstadoCurso::Abierto, 1000, 200),
            new CursoOnline(202, 'Edición de vídeo', 10, 10, EstadoCurso::Abierto, 800),
            new CursoPresencial(203, 'Dibujo digital', 6, 2, EstadoCurso::Cerrado, 900, 100),
            new CursoOnline(204, 'Fotografía creativa', 5, 0, EstadoCurso::Abierto, 1200),
        ];
    }
}
