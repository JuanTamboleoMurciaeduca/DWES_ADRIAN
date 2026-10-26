<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Modelo;

use Alquiler\Equipo\Excepcion\EquipoException;
use InvalidArgumentException;

final class EquipoFotografia extends Equipo
{
    public function __construct(
        int $id,
        string $nombre,
        int $unidades,
        int $reservadas,
        EstadoEquipo $estado,
        int $tarifaBaseCentimos,
        private readonly int $seguroCentimos,
    ) {
        // TODO M0: valida el seguro e inicializa la parte heredada.
        if($this->seguroCentimos < 0){
            throw new InvalidArgumentException('No se aceptan valores negativos en el precio');
        }
        parent::__construct($id, $nombre, $unidades, $reservadas, $estado, $tarifaBaseCentimos);
        if($this->reservadas() > $this->unidades()){
            throw new EquipoException('Las unidades reservadas no pueden ser mayor a las unidades totales');
        }
    }

    public function tipo(): string
    {
        return 'fotografia';
    }

    public function tarifaDia(): int
    {
        // TODO M1: calcula la tarifa diaria de fotografía.
        return $this->tarifaBaseCentimos + $this->seguroCentimos;
    }
}
