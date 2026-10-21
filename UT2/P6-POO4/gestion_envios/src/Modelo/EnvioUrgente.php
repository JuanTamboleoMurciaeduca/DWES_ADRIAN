<?php
declare(strict_types=1);
namespace App\Modelo;

use Override;

final class EnvioUrgente extends Envio{

    public function __construct(int $id, string $cliente, int $peso, EstadoEnvio $estado)
    {
        return parent::__construct($id, $cliente, $peso, $estado);
    }


    public function modalidad(): string
    {
        return 'urgente';
    }

    public function cuotaFija(): int
    {
        return 600;
    }

    public function precioBloque(): int
    {
        return 200;
    }
}