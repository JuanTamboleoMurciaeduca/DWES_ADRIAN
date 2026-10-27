<?php

declare(strict_types=1);

// TODO M6. Especializa Videojuego con su constructor, plazo y ficha.

class Videojuego extends Juego
{

    public function __construct(int $id, string $nombre, private string $plataforma)
    {
        parent::__construct($id, $nombre);
        if (trim($plataforma) === '')
            throw new InvalidArgumentException('Nombre de plataforma no valido');

        $this->plataforma = trim($plataforma);
    }

    public function plazoMaximo(): int
    {
        return 7;
    }

    public function plataforma(): string
    {
        return $this->plataforma;
    }

    public function ficha(): string
    {
        return parent::ficha() . ' · Plataforma: ' . $this->plataforma();
    }
}
