<?php

declare(strict_types=1);

namespace App\Contrato;
use App\Modelo\Envio;


interface RepositorioEnvios{
    public function registrar(Envio $envio): void;
    public function todos():array;
    public function buscar(int $id): ?Envio;
}