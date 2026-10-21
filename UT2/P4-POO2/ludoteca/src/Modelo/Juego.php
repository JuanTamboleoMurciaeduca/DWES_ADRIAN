<?php

declare(strict_types=1);

// TODO M4. Implementa la base abstracta Juego y las operaciones del préstamo.
abstract class Juego implements Prestable
{
    use GeneraEtiqueta;
    private int $id;
    private string $nombre;
    private bool $prestado = false;
    private int $dias = 0;

    public function __construct(int $id, string $nombre)
    {
        if ($id <= 0 || trim($nombre) === '') {
            throw new InvalidArgumentException('Error: id tiene que ser mayor a 0 y nombre tiene que tener contenido');
        }
        $this->id = $id;
        $this->nombre = trim($nombre);
    }

    public function id(): int
    {
        return $this->id;
    }
    public function nombre(): string
    {
        return $this->nombre;
    }
    public function prestado(): bool
    {
        return $this->prestado;
    }
    public function dias(): int
    {
        return $this->dias;
    }
    abstract public function plazoMaximo(): int;

    public function ficha(): string
    {
        return $this->etiqueta() . ' · ' . (!$this->prestado ? 'Disponible' : 'Prestado') . ' · Dias: ' . $this->dias;
    }

    public function prestar(int $dias): void
    {
        if ($dias <= 0)
            throw new InvalidArgumentException('Los dias deben ser positivos');
        if ($this->prestado()) {
            throw new PrestamoException('El juego ya esta prestado');
        }
        if ($dias > $this->plazoMaximo()) {
            throw new PrestamoException('Se supera el plazo maximo del juego');
        }

        $this->prestado = true;
        $this->dias = $dias;
    }

    public function renovar(int $diasExtra): void
    {
        if ($diasExtra <= 0)
            throw new InvalidArgumentException('Dias tiene que ser mayor que cero');
        if ($this->prestado() === false || ($diasExtra + $this->dias) > $this->plazoMaximo())
            throw new PrestamoException('No ha sido posible renovar el prestamo');

        $this->dias += $diasExtra;
    }

    public function devolver(): void
    {
        if (!$this->prestado())
            throw new PrestamoException('No se puede devolver un prestamo que no es de su pertenencia');

        $this->prestado = false;
        $this->dias = 0;
    }
}
