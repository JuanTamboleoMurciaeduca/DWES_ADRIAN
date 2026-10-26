<?php

declare(strict_types=1);

enum EstadoEjemplar: string
{
    case Disponible = 'disponible';
    case Prestado = 'prestado';
    case Perdido = 'perdido';
}

class Ejemplar
{
    private string $codigo;
    private EstadoEjemplar $estado;

    public function __construct(
        string $codigo,
        EstadoEjemplar $estado = EstadoEjemplar::Disponible
    ) {
        $this->codigo = $codigo;
        $this->estado = $estado;
    }

    public function codigo(): string
    {
        return $this->codigo;
    }

    public function estado(): EstadoEjemplar
    {
        return $this->estado;
    }

    public function prestar(): void
    {
        if ($this->estado !== EstadoEjemplar::Disponible) {
            throw new LogicException('Solo se puede prestar un ejemplar disponible.');
        }

        $this->estado = EstadoEjemplar::Prestado;
    }

    public function devolver(): void
    {
        if ($this->estado !== EstadoEjemplar::Prestado) {
            throw new LogicException('Solo se puede devolver un ejemplar prestado.');
        }

        $this->estado = EstadoEjemplar::Disponible;
    }

    public function marcarPerdido(): void
    {
        if (
            $this->estado !== EstadoEjemplar::Disponible
            && $this->estado !== EstadoEjemplar::Prestado
        ) {
            throw new LogicException('El ejemplar ya está marcado como perdido.');
        }

        $this->estado = EstadoEjemplar::Perdido;
    }
}

function mostrarEjemplar(Ejemplar $ejemplar): void
{
    echo $ejemplar->codigo() . ' | ' . $ejemplar->estado()->value . PHP_EOL;
}

$ejemplar1 = new Ejemplar('E-01');

$ejemplar1->prestar();
mostrarEjemplar($ejemplar1);

$ejemplar1->devolver();
mostrarEjemplar($ejemplar1);

$ejemplar1->prestar();
mostrarEjemplar($ejemplar1);

$ejemplar1->marcarPerdido();
mostrarEjemplar($ejemplar1);

try {
    $ejemplar1->devolver();
} catch (LogicException $excepcion) {
    echo 'Error al devolver E-01: ' . $excepcion->getMessage() . PHP_EOL;
}

$ejemplar2 = new Ejemplar('E-02');

try {
    $ejemplar2->devolver();
} catch (LogicException $excepcion) {
    echo 'Error al devolver E-02: ' . $excepcion->getMessage() . PHP_EOL;
}

echo 'Estados finales:' . PHP_EOL;
mostrarEjemplar($ejemplar1);
mostrarEjemplar($ejemplar2);
