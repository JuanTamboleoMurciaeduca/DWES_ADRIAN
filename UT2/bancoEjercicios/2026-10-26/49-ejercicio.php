<?php

declare(strict_types=1);

class LibroNoDisponibleException extends RuntimeException
{
}

class Libro
{
    private string $titulo;
    private bool $disponible = true;

    public function __construct(string $titulo)
    {
        $titulo = trim($titulo);

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->titulo = $titulo;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException("El libro {$this->titulo} no está disponible.");
        }

        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

$dune = new Libro('Dune');
$dune->prestar();

try {
    $dune->prestar();
} catch (LibroNoDisponibleException $excepcion) {
    echo 'Error: ' . $excepcion->getMessage() . PHP_EOL;
    echo 'La ejecución continúa.' . PHP_EOL;
    echo 'Disponible: ' . ($dune->estaDisponible() ? 'true' : 'false') . PHP_EOL;
}

$dune->devolver();
$dune->prestar();
echo 'Dune se ha devuelto y prestado de nuevo. Disponible: ';
echo ($dune->estaDisponible() ? 'true' : 'false') . PHP_EOL;

try {
    new Libro('   ');
} catch (InvalidArgumentException $excepcion) {
    echo 'Error de validación: ' . $excepcion->getMessage() . PHP_EOL;
}
