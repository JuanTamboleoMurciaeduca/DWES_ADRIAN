<?php

declare(strict_types=1);

require_once __DIR__ . '/../47-ejercicio.php';

class RecursoConOtroOrigen extends RecursoBiblioteca
{
    public function tipo(): string
    {
        return 'prueba';
    }

    public function origen(): string
    {
        return 'Otro origen';
    }
}
