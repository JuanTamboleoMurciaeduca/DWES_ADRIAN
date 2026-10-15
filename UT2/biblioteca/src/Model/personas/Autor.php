<?php
namespace App\Model\personas;
class Autor
{
    public function __construct(
        private string $nombre
    ) {}
    public function nombre(): string
    {
        return $this->nombre;
    }
}