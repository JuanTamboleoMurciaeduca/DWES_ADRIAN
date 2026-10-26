<?php

declare(strict_types=1);

class Libro
{
    public function __construct(private int $id, private string $titulo)
    {
        $this->titulo = trim($titulo);

        if ($this->id <= 0 || $this->titulo === '') {
            throw new InvalidArgumentException('El libro necesita un id positivo y un título.');
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }
}

interface LibroRepository
{
    /** @return list<Libro> */
    public function todos(): array;
}

class ArrayLibroRepository implements LibroRepository
{
    /** @param list<Libro> $libros */
    public function __construct(private array $libros)
    {
        foreach ($this->libros as $libro) {
            if (!$libro instanceof Libro) {
                throw new InvalidArgumentException('El repositorio solo admite libros.');
            }
        }
    }

    public function todos(): array
    {
        return $this->libros;
    }
}

class CatalogoDemostracionRepository implements LibroRepository
{
    public function todos(): array
    {
        return [
            new Libro(10, 'Dune'),
            new Libro(20, 'Solaris'),
        ];
    }
}

function mostrarCatalogo(LibroRepository $repositorio): void
{
    $libros = $repositorio->todos();

    if ($libros === []) {
        echo 'Catálogo vacío' . PHP_EOL;
    }

    foreach ($libros as $libro) {
        echo "{$libro->id()}: {$libro->titulo()}" . PHP_EOL;
    }

    echo 'Total: ' . count($libros) . PHP_EOL;
}

mostrarCatalogo(new CatalogoDemostracionRepository());
mostrarCatalogo(new ArrayLibroRepository([
    new Libro(30, 'Drácula'),
    new Libro(40, 'Hobbit'),
]));
mostrarCatalogo(new ArrayLibroRepository([]));
