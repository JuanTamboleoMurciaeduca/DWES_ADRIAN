<?php

declare(strict_types=1);

namespace Escuela\Curso\Modelo;

use Escuela\Curso\Excepcion\CursoException;
use InvalidArgumentException;

final class CursoPresencial extends Curso
{
    public function __construct(
        int $id,
        string $nombre,
        int $capacidad,
        int $ocupadas,
        EstadoCurso $estado,
        int $precioBaseCentimos,
        private readonly int $materialesCentimos,
    ) {
        // TODO M0: valida los materiales e inicializa la parte heredada.
        parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $precioBaseCentimos);
        if($this->materialesCentimos < 0 ){
            throw new InvalidArgumentException('El valor de materiales debe de ser un entero positivo');
        }
        if($this->ocupadas() > $this->capacidad()){
            throw new CursoException('Las plazas ocupadas no pueden ser superiores a la capacidad');
        }


    }

    public function tipo(): string
    {
        return 'presencial';
    }

    public function precioPlaza(): int
    {
        // TODO M1: calcula el precio de una plaza presencial.
        return $this->precioBaseCentimos + $this->materialesCentimos;
    }
}
