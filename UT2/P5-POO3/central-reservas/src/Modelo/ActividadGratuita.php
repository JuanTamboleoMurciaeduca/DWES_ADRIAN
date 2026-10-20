<?php
declare(strict_types=1);

// TODO M7. Implementa la especialización final gratuita.
final class ActividadGratuita extends Actividad{

    public function __construct(int $id, string $nombre, int $capacidad, int $ocupadas, EstadoActividad $estado, ?Responsable $responsable)
    {
        return parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $responsable);
    }
    
    public function tipo(): string
    {
        return 'gratuita';
    }

    public function importe(int $cantidad): int
    {
        return $cantidad < 0 ? throw new InvalidArgumentException('No se aceptan cantidades negativas')
                            : 0; 
    }
}