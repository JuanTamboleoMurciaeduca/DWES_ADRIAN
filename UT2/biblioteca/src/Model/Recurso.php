<?php
namespace App\Model;
class Recurso
{
    public function __construct(
        protected string $titulo
    ) {}
    public function titulo(): string
    {
        return $this->titulo;
    }
}