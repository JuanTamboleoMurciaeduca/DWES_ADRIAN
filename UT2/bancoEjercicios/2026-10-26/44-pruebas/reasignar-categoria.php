<?php

declare(strict_types=1);

require_once __DIR__ . '/../44-ejercicio.php';

$autor = new Autor('Frank Herbert', 'AUT-01');
$categoria = new Categoria('Ciencia ficción');
$libro = new Libro('Dune', $autor, $categoria);
$libro->categoria = new Categoria('Narrativa');
