<?php

declare(strict_types=1);

final class Libro 
{ 
    public function __construct(public string $titulo) {} 
} 
 
$original = new Libro('Dune'); 
$alias = $original; 
$otro = new Libro('Dune'); 
$alias->titulo = 'Solaris'; 
 
echo $original->titulo . PHP_EOL; 
echo $otro->titulo . PHP_EOL; 
var_dump($original === $alias); 
var_dump($original === $otro); 

//La primera salida va a devolver Dune
//La segunda salida va a devolver Dune también

//La tercera salida va a devolver true, ya que no son una copia intrínseca; sino que son exactamente el mismo objeto
//en el mismo lugar de memoria. Da igual que a $alias se le cambie el titulo, ya que en este caso también se le esta cambiando 
//el título al objeto original (son el mismo objeto)

//En cambio, la cuarta salida va a retornar false, ya que aunque los dos objetos tienen la misma propiedad y el mismo valor para dicha
//propiedad; son dos instancias diferentes de la misma clase 