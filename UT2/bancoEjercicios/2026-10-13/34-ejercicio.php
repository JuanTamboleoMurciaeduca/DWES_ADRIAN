<?php

declare(strict_types=1);

//Código Java a traducir: 

// public final class Libro { 
//     public String titulo; 
//     public boolean disponible; 
 
//     public Libro(String titulo) { 
//         this.titulo = titulo; 
//         this.disponible = true; 
//     } 
 
//     public void prestar() { 
//         this.disponible = false; 
//     } 
// } 

//Código PHP: 

final class Libro
{
    public function __construct(public string $titulo, public bool $disponible = true){}

    public function prestar():void{
        $this->disponible = false;
    }
}

$libro1 = new Libro('Dune');
echo $libro1->disponible; //True por defecto

$libro1->prestar();
echo $libro1->disponible; //False

//La sintaxis de java utiliza el punto para acceder a funciones de dichos objetos; en PHP se utiliza la flecha ->
//Lo mismo pasa con el this, pero en PHP se añade el $ delante para hacer referencia a la propiedad

//No se conserva public delante de class en PHP porque por defecto class no tiene visibilidad, y dependiendo de
//las variables y funciones que tenga dicha clase tendra una visibilidad u otra