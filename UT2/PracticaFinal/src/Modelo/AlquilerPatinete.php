<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;
use Clase\Alquileres\Modelo\Alquiler;
use Override;

class AlquilerPatinete extends Alquiler{
    
    public function __construct(int $id, string $cliente, int $dias, EstadoAlquiler $estado)
    {
        return parent::__construct($id, $cliente, $dias, $estado);
    }

    
    public function modalidad(): string
    {
        return 'patinete';    
    }
    
    protected function tarifaDiaria(): int
    {
        return 1000;
    }
}