<?php

declare(strict_types=1);
require_once __DIR__ . '/datos.php';

class Libro{
    public function __construct(public int $id, public string $titulo, public int $paginas, public bool $disponible){}

    public function prestar():void{
        $this->disponible = false;
    }
    public function devolver():void{
        $this->disponible = true;
    }
}

$coleccion = array_map(fn(array $libro): Libro=> new Libro(id: $libro['id'], paginas: $libro['paginas'],disponible: $libro['disponible'], titulo: $libro['titulo']), $datos);

