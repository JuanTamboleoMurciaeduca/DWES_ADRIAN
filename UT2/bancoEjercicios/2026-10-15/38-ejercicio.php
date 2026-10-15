<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';

final class Libro{
    public function __construct(public int $id, public string $titulo, public int $paginas, public bool $disponible){}
}

$coleccion = array_map(fn(array $libro): Libro=> new Libro(id: $libro['id'], $libro['paginas'], $libro['disponible'], titulo: $libro['titulo']), $datos);

