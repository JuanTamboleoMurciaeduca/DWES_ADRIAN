<?php

declare(strict_types=1);

abstract class RecursoBiblioteca
{
    private int $id;
    protected string $titulo;

    public function __construct(int $id, string $titulo)
    {
        $titulo = trim($titulo);

        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser mayor que cero.');
        }

        if ($titulo === '') {
            throw new InvalidArgumentException('El título no puede estar vacío.');
        }

        $this->id = $id;
        $this->titulo = $titulo;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    abstract public function tipo(): string;

    final public function origen(): string
    {
        return 'Biblioteca';
    }
}

class Libro extends RecursoBiblioteca
{
    private int $paginas;

    public function __construct(int $id, string $titulo, int $paginas)
    {
        parent::__construct($id, $titulo);

        if ($paginas <= 0) {
            throw new InvalidArgumentException('El número de páginas debe ser mayor que cero.');
        }

        $this->paginas = $paginas;
    }

    public function tipo(): string
    {
        return 'libro';
    }

    public function ficha(): string
    {
        return "{$this->titulo} — {$this->paginas} páginas";
    }
}

class Revista extends RecursoBiblioteca
{
    private int $numero;

    public function __construct(int $id, string $titulo, int $numero)
    {
        parent::__construct($id, $titulo);

        if ($numero <= 0) {
            throw new InvalidArgumentException('El número de la revista debe ser mayor que cero.');
        }

        $this->numero = $numero;
    }

    public function tipo(): string
    {
        return 'revista';
    }

    public function ficha(): string
    {
        return "{$this->titulo} — número {$this->numero}";
    }
}

function ejecutarDemostracion47(): void
{
    $recursos = [
        new Libro(10, 'Dune', 412),
        new Revista(20, 'Revista Ciencia', 7),
    ];

    foreach ($recursos as $recurso) {
        echo "{$recurso->id()} | {$recurso->titulo()} | {$recurso->tipo()} | {$recurso->origen()}" . PHP_EOL;
        echo $recurso->ficha() . PHP_EOL;
    }
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    ejecutarDemostracion47();
}
