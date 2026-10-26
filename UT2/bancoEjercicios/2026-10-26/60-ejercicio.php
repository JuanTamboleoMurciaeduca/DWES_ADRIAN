<?php

declare(strict_types=1);

$registros = [
    ['titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
    ['titulo' => 'Solaris', 'paginas' => 216, 'disponible' => false],
    ['titulo' => 'Drácula', 'paginas' => 418, 'disponible' => true],
    ['titulo' => 'El Hobbit', 'paginas' => 310, 'disponible' => true],
];

function titulosDisponiblesHasta(array $datos, int $maximo): array
{
    if ($maximo < 1) {
        throw new InvalidArgumentException('El máximo de páginas debe ser mayor que cero.');
    }

    $disponibles = array_filter(
        $datos,
        fn (array $libro): bool =>
            $libro['disponible'] && $libro['paginas'] <= $maximo
    );

    return array_map(
        fn (array $libro): string => $libro['titulo'],
        $disponibles
    );
}

class Libro
{
    public function __construct(
        private string $titulo,
        private int $paginas,
        private bool $disponible
    ) {
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function paginas(): int
    {
        return $this->paginas;
    }

    public function estaDisponible(): bool
    {
        return $this->disponible;
    }
}

class CatalogoService
{
    private array $libros;

    public function __construct(array $libros)
    {
        $this->libros = $libros;
    }

    public function titulosDisponiblesHasta(int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException('El máximo de páginas debe ser mayor que cero.');
        }

        $disponibles = array_filter(
            $this->libros,
            fn (Libro $libro): bool =>
                $libro->estaDisponible() && $libro->paginas() <= $maximo
        );

        return array_map(
            fn (Libro $libro): string => $libro->titulo(),
            $disponibles
        );
    }
}

function mostrarTitulos(string $version, int $maximo, array $titulos): void
{
    $resultado = $titulos === [] ? 'lista vacía' : implode(', ', $titulos);
    echo "{$version} ({$maximo} páginas): {$resultado}" . PHP_EOL;
}

$libros = array_map(
    fn (array $registro): Libro => new Libro(
        $registro['titulo'],
        $registro['paginas'],
        $registro['disponible']
    ),
    $registros
);

$catalogo = new CatalogoService($libros);

foreach ([400, 500, 100] as $maximo) {
    mostrarTitulos(
        'Versión funcional',
        $maximo,
        titulosDisponiblesHasta($registros, $maximo)
    );
    mostrarTitulos(
        'Versión con objetos',
        $maximo,
        $catalogo->titulosDisponiblesHasta($maximo)
    );
}

try {
    titulosDisponiblesHasta($registros, 0);
} catch (InvalidArgumentException $excepcion) {
    echo 'Error en versión funcional: ' . $excepcion->getMessage() . PHP_EOL;
}

try {
    $catalogo->titulosDisponiblesHasta(0);
} catch (InvalidArgumentException $excepcion) {
    echo 'Error en versión con objetos: ' . $excepcion->getMessage() . PHP_EOL;
}
