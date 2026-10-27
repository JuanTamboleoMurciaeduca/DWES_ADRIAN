<?php

declare(strict_types=1);

namespace Clase\Alquileres\Modelo;


use InvalidArgumentException;
use Clase\Alquileres\Excepcion\AlquilerException;

abstract class Alquiler
{
    public function __construct(
        private readonly int $id,
        private string $cliente,
        private int $dias,
        private EstadoAlquiler $estado
    ) {
        if ($this->id() <= 0) {
            throw new InvalidArgumentException('No se aceptan valores negativos');
        }
        if (trim($this->cliente) === '') {
            throw new InvalidArgumentException('El cliente es un parámetro obligatorio');
        }
        if ($this->dias() < 1 || $this->dias() > 7) {
            throw new InvalidArgumentException('La duración debe permanecer dentro del plazo');
        }
        // Guarda $cliente sin espacios en los extremos; conserva los interiores.
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
    public function dias(): int
    {
        return $this->dias;
    }
    public function estado(): EstadoAlquiler
    {
        return $this->estado;
    }
    public abstract function modalidad(): string;
    protected abstract function tarifaDiaria(): int;

    public function iniciar(): void
    {
        if ($this->estado() !== EstadoAlquiler::Reservado) {
            throw new AlquilerException('Valor de partida no admitido para esta operacion');
        }
        $this->estado = EstadoAlquiler::Activo;
    }

    public function finalizar(): void
    {
        if ($this->estado() !== EstadoAlquiler::Activo) {
            throw new AlquilerException('Valor de partida no valido para esta operacion');
        }
        $this->estado = EstadoAlquiler::Finalizado;
    }

    public function importe(): int
    {
        return $this->dias() * $this->tarifaDiaria();
    }
}
