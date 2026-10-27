<?php

declare(strict_types=1);

final class Libro
{
    public function __construct(
        public string $titulo,
        public ?Autor $autor = null
    ) {}
}

$conAutor = new Libro('Dune', new Autor('Frank Herbert'));
$sinAutor = new Libro('Relato anónimo');

echo $conAutor?->titulo;
echo $sinAutor?->titulo ?? 'Sin autor';
