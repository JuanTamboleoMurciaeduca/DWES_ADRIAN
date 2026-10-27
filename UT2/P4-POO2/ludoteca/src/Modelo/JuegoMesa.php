<?php

declare(strict_types=1);

// TODO M5. Especializa JuegoMesa con su constructor, plazo y ficha.
class JuegoMesa extends Juego
{


    public function __construct(int $id, string $nombre, private int $jugadores)
    {
        parent::__construct($id, $nombre);
        if ($jugadores <= 0)
            throw new InvalidArgumentException('El numero de jugadores debe ser mayor a 0');
    }

    public function jugadores(): int
    {
        return $this->jugadores;
    }

    public function plazoMaximo(): int
    {
        return 14;
    }

    #[Override]
    public function ficha(): string
    {
        return parent::ficha() . ' · Jugadores: ' . $this->jugadores();
    }
}
