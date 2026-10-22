<?php

declare(strict_types=1);

namespace App\Repositorio;

use App\Modelo\Envio;
use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use InvalidArgumentException;

class RepositorioEnviosMemoria implements RepositorioEnvios{
    private array $envios = [];
    public function registrar(Envio $envio): void
    {
        foreach ($this->envios as $existente) {
            if ($existente->id() === $envio->id()) {
                throw new EnvioException('No se admiten envios duplicados');
            }
        }

        $this->envios[] = $envio;
    }
    public function todos():array{
        return $this->envios;
    }
    public function buscar(int $id): ?Envio{
        if($id <= 0)
            throw new InvalidArgumentException('El id debe de ser un valor positivo');
        return array_find(
            $this->todos(),
            fn(Envio $e):bool => $e->id() === $id
        ) ?? null;
    }
}