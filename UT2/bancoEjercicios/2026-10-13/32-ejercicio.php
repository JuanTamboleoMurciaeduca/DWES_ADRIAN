<?php

declare(strict_types=1);

class Libro5{
    public function __construct(public string $titulo, public int $paginas){}

    public function ficha():string{
        return $this->titulo . ' - ' . $this->paginas;
    }
    
    public function mostrarFicha():void{
        echo $this->ficha();
    }
}

$esteLibro = new Libro5('Dune', 412);

$ficha = $esteLibro->ficha();

echo 'Ficha: ' . $ficha;
echo '<br>';
$esteLibro->mostrarFicha();

//La diferencia es que con el return, el valor es reutilizable, es decir; return entrega el valor del código que se está llamando.
//Por otro lado, una funcion void que realiza un echo escribe la salida pero no devuelve ese texto