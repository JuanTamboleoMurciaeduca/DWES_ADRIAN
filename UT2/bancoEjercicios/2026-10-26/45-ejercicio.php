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
    public function __construct(
        private string $codigo,
        private EstadoEjemplar $estado = EstadoEjemplar::Disponible
    ) {
        $this->codigo = trim($codigo);

        if ($this->codigo === '') {
            throw new InvalidArgumentException('El código no puede estar vacío.');
        }
    }

    public function codigo(): string
    {
        return $this->codigo;
    }

    public function estado(): EstadoEjemplar
    {
        return $this->estado;
    }

    public function cambiarEstado(EstadoEjemplar $estado): void
    {
        $this->estado = $estado;
    }
}

function mostrarEjemplar(Ejemplar $ejemplar): void
{
    echo "{$ejemplar->codigo()}: {$ejemplar->estado()->name} / {$ejemplar->estado()->value}" . PHP_EOL;
}

$ejemplares = [
    new Ejemplar('E-01'),
    new Ejemplar('E-02', EstadoEjemplar::Prestado),
    new Ejemplar('E-03', EstadoEjemplar::Perdido),
];

foreach ($ejemplares as $ejemplar) {
    mostrarEjemplar($ejemplar);
}

$disponibles = array_filter(
    $ejemplares,
    static fn (Ejemplar $ejemplar): bool => $ejemplar->estado() === EstadoEjemplar::Disponible
);
echo 'Disponibles inicialmente: ' . count($disponibles) . PHP_EOL;

foreach (['prestado', 'perdido', 'reservado'] as $textoEstado) {
    $estado = EstadoEjemplar::tryFrom($textoEstado);

    if ($estado === null) {
        echo "Estado «{$textoEstado}» inválido; E-01 conserva {$ejemplares[0]->estado()->value}." . PHP_EOL;
        continue;
    }

    $ejemplares[0]->cambiarEstado($estado);
    echo "E-01 cambia a {$estado->name} / {$estado->value}." . PHP_EOL;
}

echo 'Estados definidos:' . PHP_EOL;
foreach (EstadoEjemplar::cases() as $estado) {
    echo "- {$estado->name}: {$estado->value}" . PHP_EOL;
}

foreach (EstadoEjemplar::cases() as $estado) {
    $total = count(array_filter(
        $ejemplares,
        static fn (Ejemplar $ejemplar): bool => $ejemplar->estado() === $estado
    ));
    echo "{$estado->value}: {$total}" . PHP_EOL;
}
