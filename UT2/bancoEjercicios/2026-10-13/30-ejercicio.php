<?php

declare(strict_types=1);
//Clase a reescribir: 
// final class Libro 
// { 
//     public string $titulo; 
//     public bool $disponible; 

//     public function __construct( 
//         string $titulo, bool $disponible = true 
//     ) { 
//         $this->titulo = $titulo; 
//         $this->disponible = $disponible; 
//     } 
// } 

final class Libro2
{
    public function __construct(public string $titulo, public bool $disponible = true) {}
}

$libro = new Libro2('Dune');
$libro3 = new Libro2('Solaris', false);

var_dump($libro);
echo '<br>';
var_dump($libro3);


//El primer argumento es el que utiliza el valor por defecto, ya que no le especificamos el valor del segundo argumento
//Si se omitiese el titulo obligatorio, se produciria un ArgumentCountError, que explica que no hay suficientes argumentos