<?php

declare(strict_types=1);

// Reparación 1: el archivo y su case coinciden con Libro.php.
namespace App\Model;

final class Libro
{
    public function __construct(private string $titulo)
    {
    }

    public function titulo(): string
    {
        return $this->titulo;
    }
}
