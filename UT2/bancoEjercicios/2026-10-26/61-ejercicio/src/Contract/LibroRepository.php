<?php

declare(strict_types=1);

namespace App\Contract;

use App\Model\Libro;

interface LibroRepository
{
    /** @return Libro[] */
    public function todos(): array;

    public function buscarPorId(int $id): ?Libro;
}
