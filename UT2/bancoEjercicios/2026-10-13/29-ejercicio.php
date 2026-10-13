<?php

final class Libro1
{ 
    public string $titulo; 
    public int $paginas = 0; 
    public bool $disponible = true; 
} 
 
//$libro = new Libro(); 

//En esta clase están inicializadas las propiedades $titulo, $paginas y $disponible, siendo las dos primeras 
//de tipo string, y $disponible de tipo bool

//Si intentasemos leer libro inmediatamente sin haberla inicializado antes, se produciría un error

$libro = new Libro1();

$libro->titulo = 'Solaris';
$libro->paginas = 216;

//Una clase hija que use extends Libro1 en este caso daria error porque la propiedad final no permite que 
//se creen clases que hereden de esta clase Libro1