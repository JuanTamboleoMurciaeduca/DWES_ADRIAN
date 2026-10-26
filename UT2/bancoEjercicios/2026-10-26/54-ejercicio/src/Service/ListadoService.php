<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Recurso;

final class ListadoService
{
    /**
     * @param Recurso[] $recursos
     * @return string[]
     */
    public function lineas(array $recursos): array
    {
        return array_map(
            static fn (Recurso $recurso): string => $recurso->tipo() . ': ' . $recurso->titulo(),
            $recursos,
        );
    }
}
