<?php

declare(strict_types=1);

namespace Clase\Alquileres\Servicio;

use Clase\Alquileres\Modelo\EstadoAlquiler;
use Clase\Alquileres\Modelo\Alquiler;

class ServicioAlquileres{
    public function __construct(private array $alquileres){}

    public function todos():array{
        return $this->alquileres;
    }

    public function consultar(string $texto = '', ?EstadoAlquiler $estado = null): array{
        $consultaFiltrada=  array_filter(
            $this->todos(),
            fn(Alquiler $a): bool=>
                ($this->normalizar($texto) === '' || str_contains($this->normalizar($a->cliente()), $this->normalizar($texto))) &&
                (is_null($estado) || $a->estado() === $estado) //Revisar
        );
        if($consultaFiltrada === []){
            return [];
        }
        usort(
            $consultaFiltrada, 
            fn(Alquiler $a, Alquiler $b): int=>
                [$a->importe(), $a->id()] <=> [$b->importe(), $b->id()]    
        );
        return $consultaFiltrada;
    }

    private function normalizar(string $texto):string{
        return mb_strtolower(trim($texto), 'UTF-8');
    }

    public function resumir(array $alquileres): array{
        return array_reduce(
            $alquileres, 
            function(array $carry, Alquiler $item){
                $carry['cantidad']++; 
                $carry['importe'] += $item->importe();
                return $carry;
            }, 
            ['cantidad' => 0, 'importe' => 0]
        );
    }


}