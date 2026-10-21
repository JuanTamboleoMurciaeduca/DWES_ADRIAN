<?php
declare(strict_types=1);
namespace App\Modelo;

use Override;

final class EnvioNormal extends Envio{
    public function __construct(int $id, string $cliente, int $peso, EstadoEnvio $estado)
    {
        return parent::__construct($id, $cliente, $peso, $estado);
    }


    public function modalidad(): string
    {
        return 'normal';
    }

    public function cuotaFija(): int
    {
        return 350;
    }

    public function precioBloque(): int
    {
        return 120;
    }
}