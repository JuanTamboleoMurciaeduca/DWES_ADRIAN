<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;

use Override;

class AlquilerBicicleta extends Alquiler{

    public function __construct(int $id, string $cliente, int $dias, EstadoAlquiler $estado)
    {
        return parent::__construct($id, $cliente, $dias, $estado);
    }


    public function modalidad(): string
    {
        return 'bicicleta';
    }
    
    protected function tarifaDiaria(): int
    {
        return 500;    
    }
}