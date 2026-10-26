<?php

declare(strict_types=1);

namespace App\Model;

final class Autor
{
    public function __construct(private string $nombre)
    {
    }

    public function nombre(): string
    {
        return $this->nombre;
    }
}
