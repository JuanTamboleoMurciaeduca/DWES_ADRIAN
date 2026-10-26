<?php

declare(strict_types=1);

class Libro
{
    private int $id;
    private string $titulo;
    private int $paginas;
    private bool $disponible;

    public function __construct(int $id, string $titulo, int $paginas, bool $disponible = true)
    {
        $titulo = trim($titulo);

        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser mayor que cero.');
        }

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        if ($paginas <= 0) {
            throw new InvalidArgumentException('El número de páginas debe ser mayor que cero.');
        }

        $this->id = $id;
        $this->titulo = $titulo;
        $this->paginas = $paginas;
        $this->disponible = $disponible;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }

    public function prestar(): void
    {
        if (!$this->disponible) {
            throw new LogicException("El libro {$this->titulo} ya está prestado.");
        }

        $this->disponible = false;
    }

    public function devolver(): void
    {
        $this->disponible = true;
    }
}

function mostrarLibro(Libro $libro): void
{
    echo "Libro {$libro->id()}: {$libro->titulo()}, {$libro->paginas()} páginas, disponible: ";
    echo ($libro->estaDisponible() ? 'sí' : 'no') . PHP_EOL;
}

$dune = new Libro(10, 'Dune', 412);
$solaris = new Libro(20, 'Solaris', 216);

mostrarLibro($dune);
mostrarLibro($solaris);

$dune->prestar();
mostrarLibro($dune);
mostrarLibro($solaris);

$dune->devolver();
mostrarLibro($dune);

try {
    $dune->prestar();
    $dune->prestar();
} catch (LogicException $excepcion) {
    echo 'Error: ' . $excepcion->getMessage() . PHP_EOL;
    echo 'La ejecución continúa.' . PHP_EOL;
    echo 'Estado de Dune: ' . ($dune->estaDisponible() ? 'disponible' : 'prestado') . PHP_EOL;
}

try {
    new Libro(0, 'Libro inválido', 100);
} catch (InvalidArgumentException $excepcion) {
    echo 'Error de validación: ' . $excepcion->getMessage() . PHP_EOL;
}
