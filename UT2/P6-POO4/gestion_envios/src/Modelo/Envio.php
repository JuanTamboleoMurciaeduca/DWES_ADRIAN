<?php

declare(strict_types=1);

namespace App\Modelo;

use App\Modelo\EstadoEnvio;
use App\Excepcion\EnvioException;
use InvalidArgumentException;

abstract class Envio
{


    public function __construct(
        private readonly int $id,
        private string $cliente,
        private int $peso,
        private EstadoEnvio $estado
    ) {
        if ($this->id() <= 0) {
            throw new InvalidArgumentException('El valor id debe de ser un entero positivo');
        }
        if (trim($this->cliente()) === '') {
            throw new InvalidArgumentException('Cliente es un campo obligatorio');
        }
        if ($this->peso() < 1 || $this->peso() > 20000) {
            throw new InvalidArgumentException('El peso no se encuentra dentro de los valores permitidos');
        }
        $this->cliente = trim($this->cliente);
    }


    public function id(): int
    {
        return $this->id;
    }
    public function cliente(): string
    {
        return $this->cliente;
    }
    public function peso(): int
    {
        return $this->peso;
    }
    public function estado(): EstadoEnvio
    {
        return $this->estado;
    }
    public abstract function modalidad(): string;

    protected abstract function cuotaFija(): int;
    protected abstract function precioBloque(): int;

    public function tarifa(): int
    {
        $bloques = intdiv($this->peso() + 999, 1000);

        return $this->cuotaFija() + $bloques * $this->precioBloque();
    }

    private function cambiarEstado(EstadoEnvio $origen, EstadoEnvio $destino): void
    {
        if ($this->estado !== $origen) {
            throw new EnvioException('Operacion no valida, el estado de partida admitido es ' . $origen->value . ' y el envio esta ' . $this->estado->value);
        }
        $this->estado = $destino;
    }

    public function enviar(): void
    {
        $this->cambiarEstado(EstadoEnvio::Pendiente, EstadoEnvio::Enviado);
    }
    public function entregar(): void
    {
        $this->cambiarEstado(EstadoEnvio::Enviado, EstadoEnvio::Entregado);
    }
    public function cancelar(): void
    {
        $this->cambiarEstado(EstadoEnvio::Pendiente, EstadoEnvio::Cancelado);
    }
}
