<?php

declare(strict_types=1);

final class Libro 
{ 
    public function __construct( 
        public string $titulo, 
        public int $paginas, 
)   { 
    // Validar los argumentos. 
    if(trim($titulo) === '' || $paginas <= 0){
        throw new InvalidArgumentException('Argumento/s invalido');
    }
    } 
} 

$caso1 = new Libro('Dune', 412);
$caso2 = new Libro(' ', 100);
$caso3 = new Libro('Solaris', 0);
$caso4 = new Libro('Solaris', -4);