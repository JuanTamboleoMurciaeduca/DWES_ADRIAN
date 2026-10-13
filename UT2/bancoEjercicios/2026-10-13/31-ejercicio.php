<?php

final class Libro4 
{ 
    public function __construct( 
        public string $titulo, 
        public bool $disponible = true, 
    ) {} 
 
    public function prestar(): void 
    { 
        $this->disponible = false; 
    } 
 
    public function devolver(): void 
    { 
        $this->disponible = true; 
    } 
} 

$primerLibro = new Libro4('Dune');
$segundoLibro = new Libro4('Solaris');

//Prestar Dune

$primerLibro->prestar();

echo $primerLibro->disponible;
echo $segundoLibro->disponible;

//Cambiar un objeto no cambia otro porque, aunque se utilice la misma clase, las instancias de los dos objetos son diferentes
//y se guardan en dos posiciones de memoria diferentes, sus propiedades no son iguales pero si sus funciones como objeto

