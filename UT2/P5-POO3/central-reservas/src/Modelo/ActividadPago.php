<?php
declare(strict_types=1);

// TODO M7. Implementa la especialización final de pago y su constructor.
final class ActividadPago extends Actividad{

    public function __construct(int $id, string $nombre, int $capacidad, int $ocupadas, EstadoActividad $estado, ?Responsable $responsable, private readonly int $precioCentimos)
    {
        if($precioCentimos <= 0){
            throw new InvalidArgumentException('El precio debe de ser una cantidad mayor que 0');
        }
        parent::__construct($id, $nombre, $capacidad, $ocupadas, $estado, $responsable);
    }

    public function tipo(): string
    {
        return 'pago';
    }

    public function importe(int $cantidad): int
    {
        return $cantidad < 0 ? (throw new InvalidArgumentException('No se aceptan cantidades negativas')) : (int) ($cantidad * $this->precioCentimos);
    }

}