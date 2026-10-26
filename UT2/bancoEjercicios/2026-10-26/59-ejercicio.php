<?php

declare(strict_types=1);

class OperacionBibliotecaException extends RuntimeException
{
}

class LibroNoDisponibleException extends OperacionBibliotecaException
{
}

class Libro
{
    private string $titulo;
    private bool $disponible;

    public function __construct(string $titulo, bool $disponible = true)
    {
        $this->titulo = $titulo;
        $this->disponible = $disponible;
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
            throw new LibroNoDisponibleException(
                "El libro {$this->titulo} no está disponible."
            );
        }

        $this->disponible = false;
    }
}

function prestarPorId(array $libros, int $id): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('El identificador debe ser mayor que cero.');
    }

    if (!isset($libros[$id])) {
        throw new OperacionBibliotecaException('No existe un libro con ese identificador.');
    }

    $libros[$id]->prestar();
}

$libros = [
    10 => new Libro('Dune'),
    20 => new Libro('Solaris', false),
];

foreach ([10, 10, 20, 99, 0] as $id) {
    try {
        prestarPorId($libros, $id);
        echo "ID {$id}: Préstamo realizado." . PHP_EOL;
    } catch (LibroNoDisponibleException $excepcion) {
        echo "ID {$id}: préstamo rechazado. Motivo: {$excepcion->getMessage()}" . PHP_EOL;
    } catch (OperacionBibliotecaException $excepcion) {
        echo "ID {$id}: operación rechazada. Motivo: {$excepcion->getMessage()}" . PHP_EOL;
    } catch (InvalidArgumentException $excepcion) {
        echo "ID {$id}: identificador rechazado. Motivo: {$excepcion->getMessage()}" . PHP_EOL;
    } finally {
        echo "Fin de operación ID {$id}." . PHP_EOL;
    }
}

echo 'Disponibilidad final:' . PHP_EOL;

foreach ($libros as $id => $libro) {
    $estado = $libro->estaDisponible() ? 'disponible' : 'prestado';
    echo "ID {$id} | {$libro->titulo()} | {$estado}" . PHP_EOL;
}
