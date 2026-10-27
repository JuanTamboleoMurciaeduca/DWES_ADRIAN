<?php

declare(strict_types=1);

class Autor
{
    public function __construct(public string $nombre) {}
}

class Categoria
{
    public function __construct(public string $nombre) {}
}

class Libro
{
    public function __construct(
        public string $titulo,
        public Autor $autor,
        public Categoria $categoria
    ) {}
}

$autor = new Autor('Frank Herbert');
$categoria = new Categoria('Ciencia ficción');

$libro = new Libro('Dune', $autor, $categoria);

echo 'Titulo: ' . $libro->titulo . ', autor: ' . $libro->autor->nombre . ', categoria: ' . $libro->categoria->nombre;

//Autor contiene un objeto y no una cadena porque en la variable $autor estamos guardando el objeto instanciado mediante la clase Autor.
//Dicho objeto contiene la propiedad $nombre, que sí es un string