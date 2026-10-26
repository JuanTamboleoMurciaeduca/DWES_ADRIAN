<?php

declare(strict_types=1);

namespace App\Model;

abstract class Recurso
{
    public function __construct(protected string $titulo)
    {
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    abstract public function tipo(): string;
}
