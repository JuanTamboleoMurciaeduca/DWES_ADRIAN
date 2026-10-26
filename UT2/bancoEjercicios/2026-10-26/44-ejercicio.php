<?php

declare(strict_types=1);

class Autor
{
    public readonly string $nombre;
    public readonly string $codigo;

    public function __construct(string $nombre, string $codigo)
    {
        $nombre = trim($nombre);
        $codigo = trim($codigo);

        if ($nombre === '' || $codigo === '') {
            throw new InvalidArgumentException('El nombre y el código del autor son obligatorios.');
        }

        $this->nombre = $nombre;
        $this->codigo = $codigo;
    }
}

class Categoria
{
    private string $nombre;

    public function __construct(string $nombre)
    {
        $this->renombrar($nombre);
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function renombrar(string $nombre): void
    {
        $nombre = trim($nombre);

        if ($nombre === '') {
            throw new InvalidArgumentException('El nombre de la categoría no puede estar vacío.');
        }

        $this->nombre = $nombre;
    }
}

class Libro
{
    private string $titulo;

    public function __construct(
        string $titulo,
        public readonly Autor $autor,
        public readonly Categoria $categoria
    ) {
        $titulo = trim($titulo);

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->titulo = $titulo;
    }

    public function ficha(): string
    {
        return "{$this->titulo} — {$this->autor->nombre} ({$this->autor->codigo}) — {$this->categoria->nombre()}";
    }
}

function ejecutarDemostracion44(): void
{
    $autor = new Autor('Frank Herbert', 'AUT-01');
    $categoria = new Categoria('Ciencia ficción');
    $dune = new Libro('Dune', $autor, $categoria);
    $mesiasDeDune = new Libro('El mesías de Dune', $autor, $categoria);

    echo $dune->ficha() . PHP_EOL;
    echo $mesiasDeDune->ficha() . PHP_EOL;

    $categoria->renombrar('Narrativa');

    echo $dune->ficha() . PHP_EOL;
    echo $mesiasDeDune->ficha() . PHP_EOL;
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    ejecutarDemostracion44();
}
