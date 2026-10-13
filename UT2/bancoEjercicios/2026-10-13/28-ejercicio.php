<?php

declare(strict_types=1);
//Array
$datos = [ 
    'titulo' => 'Dune', 
    'autor' => 'Frank Herbert', 
    'paginas' => 412, 
    'disponible' => true, 
]; 

//Clase

class Libro{
    public string $titulo = 'Dune';
    public string $autor = 'Frank Herbert';
    public int $paginas = 412; 
    public bool $disponible = true;

    public function __construct(string $titulo, string $autor, int $paginas, bool $disponible)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->paginas = $paginas;
        $this->disponible = $disponible;
    }
}