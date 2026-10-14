<?php

declare(strict_types=1);

final class Sesion
{
    public function __construct(public string $nombre, 
                                public int $capacidadMax, 
                                public int $plazasOcupadas = 0)
            {
                if(trim($this->nombre) === ''){
                    throw new InvalidArgumentException('El nombre de la sesion no puede estar vacio');
                }
                if($capacidadMax <= 0){
                    throw new InvalidArgumentException('La capacidad debe ser mayor a cero');
                }
            }
    public function plazasLibres(): int{
        return $this->capacidadMax - $this->plazasOcupadas;
    }

    
}