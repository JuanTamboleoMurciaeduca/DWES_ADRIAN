<?php

declare(strict_types=1);

trait TieneFechaCreacion
{
    private string $fechaCreacion;

    private function inicializarFechaCreacion(string $fecha): void
    {
        $fecha = trim($fecha);

        if ($fecha === '') {
            throw new InvalidArgumentException('La fecha de creación no puede estar vacía.');
        }

        $this->fechaCreacion = $fecha;
    }

    public function fechaCreacion(): string
    {
        return $this->fechaCreacion;
    }

    public function etiquetaCreacion(): string
    {
        return "Creado el {$this->fechaCreacion}";
    }
}

class Libro
{
    use TieneFechaCreacion;

    public function __construct(private string $titulo, string $fechaCreacion)
    {
        $this->titulo = trim($titulo);

        if ($this->titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->inicializarFechaCreacion($fechaCreacion);
    }

    public function titulo(): string
    {
        return $this->titulo;
    }
}

class Socio
{
    use TieneFechaCreacion;

    public function __construct(private string $nombre, string $fechaCreacion)
    {
        $this->nombre = trim($nombre);

        if ($this->nombre === '') {
            throw new InvalidArgumentException('El nombre no puede estar vacío.');
        }

        $this->inicializarFechaCreacion($fechaCreacion);
    }

    public function nombre(): string
    {
        return $this->nombre;
    }
}

$dune = new Libro('Dune', '2026-10-01');
$solaris = new Libro('Solaris', '2026-10-02');
$ana = new Socio('Ana', '2026-10-03');

echo "{$dune->titulo()} | {$dune->fechaCreacion()} | {$dune->etiquetaCreacion()}" . PHP_EOL;
echo "{$solaris->titulo()} | {$solaris->fechaCreacion()} | {$solaris->etiquetaCreacion()}" . PHP_EOL;
echo "{$ana->nombre()} | {$ana->fechaCreacion()} | {$ana->etiquetaCreacion()}" . PHP_EOL;
