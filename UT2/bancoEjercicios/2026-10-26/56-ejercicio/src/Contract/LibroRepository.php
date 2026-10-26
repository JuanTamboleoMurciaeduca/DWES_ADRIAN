<?php

declare(strict_types=1);

namespace App\Contract;

interface LibroRepository
{
    public function todos(): array;
}
