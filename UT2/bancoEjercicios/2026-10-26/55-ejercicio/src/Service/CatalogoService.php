<?php

declare(strict_types=1);

// Reparación 2: el namespace correcto es Service, en singular.
namespace App\Service;

// Reparación 3: Libro se importa desde App\Model.
use App\Model\Libro;

final class CatalogoService
{
    public function mostrar(Libro $libro): string
    {
        return $libro->titulo();
    }
}
