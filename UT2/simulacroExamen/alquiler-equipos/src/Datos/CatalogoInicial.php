<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Datos;

use Alquiler\Equipo\Modelo\{EquipoFotografia, EquipoSonido, EstadoEquipo};

final class CatalogoInicial
{
    public function equipos(): array
    {
        return [
            new EquipoFotografia(501, 'Cámara híbrida', 7, 2, EstadoEquipo::Disponible, 1800, 200),
            new EquipoSonido(502, 'Micrófono inalámbrico', 4, 4, EstadoEquipo::Disponible, 800),
            new EquipoFotografia(503, 'Cámara de acción', 6, 1, EstadoEquipo::Disponible, 1200, 300),
            new EquipoSonido(504, 'Altavoz portátil', 5, 1, EstadoEquipo::Disponible, 1500),
            new EquipoSonido(505, 'Mesa de mezclas', 3, 1, EstadoEquipo::EnRevision, 2500),
        ];
    }
}
