<?php

declare(strict_types=1);

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Datos\CatalogoInicial;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{CursoOnline, CursoPresencial, EstadoCurso};
use Escuela\Curso\Repositorio\ArrayCursoRepository;
use Escuela\Curso\Servicio\CatalogoService;

$autoload = __DIR__ . '/../vendor/autoload.php';

if (!is_file($autoload)) {
    fwrite(STDERR, "Completa C0 y ejecuta composer dump-autoload.\n");
    exit(1);
}

require $autoload;

if (!class_exists(CatalogoInicial::class)) {
    fwrite(STDERR, "Completa C0: configura Escuela\\Curso\\ para src/ y regenera el autoloader.\n");
    exit(1);
}

function mostrar(string $titulo, callable $accion): void
{
    echo "\n", $titulo, "\n";

    try {
        echo json_encode($accion(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), "\n";
    } catch (\InvalidArgumentException | CursoException $e) {
        echo 'Rechazo: ', $e->getMessage(), "\n";
    } catch (\LogicException $e) {
        echo $e->getMessage(), "\n";
    }
}

$repository = new ArrayCursoRepository((new CatalogoInicial())->cursos());
$service = new CatalogoService($repository);

echo 'Catálogo cargado: ', count($repository->todos()), " cursos.\n";

mostrar('Casos del enum', fn (): array => [
    'abierto' => EstadoCurso::Abierto->value,
    'cerrado' => EstadoCurso::Cerrado->value,
    'valorDesconocido' => EstadoCurso::tryFrom('inventado') === null
]);

mostrar('Contrato del repositorio', fn (): array => [
    'cumpleContrato' => $repository instanceof CursoRepository,
    'cantidad' => count($repository->todos()),
    'curso203' => $repository->buscarPorId(203)->id(),
    'inexistente' => $repository->buscarPorId(999) === null
]);

mostrar('Excepción de dominio', function (): void {
    throw new CursoException('El curso no admite reservas');
});

mostrar('Constructor presencial con materiales a cero', function (): array {
    $curso = new CursoPresencial(301, '  Cerámica  ', 4, 1, EstadoCurso::Abierto, 1500, 0);

    return [
        'id' => $curso->id(),
        'nombre' => $curso->nombre(),
        'capacidad' => $curso->capacidad(),
        'ocupadas' => $curso->ocupadas(),
        'estado' => $curso->estado()->value,
        'precioPlaza' => $curso->precioPlaza()
    ];
});

mostrar('Constructor con materiales negativos', function (): void {
    new CursoPresencial(301, 'Cerámica', 4, 1, EstadoCurso::Abierto, 1500, -1);
});

mostrar('Constructor con más ocupadas que capacidad', function (): void {
    new CursoPresencial(301, 'Cerámica', 4, 5, EstadoCurso::Abierto, 1500, 0);
});

mostrar('Opciones para 2 plazas y 2400 céntimos', fn (): array => $service->buscarOpciones(2, 2400));

mostrar('Opciones para 6 plazas y 10000 céntimos', fn (): array => $service->buscarOpciones(6, 10000));

mostrar('Opciones para 0 plazas y 2400 céntimos', fn (): array => $service->buscarOpciones(0, 2400));

$alternativo = new CatalogoService(new ArrayCursoRepository([
    new CursoOnline(310, 'Edición sonora', 5, 0, EstadoCurso::Abierto, 900),
    new CursoPresencial(305, 'Lettering', 4, 0, EstadoCurso::Abierto, 300, 100),
    new CursoOnline(304, 'Collage', 4, 0, EstadoCurso::Abierto, 400),
    new CursoOnline(309, 'Curso cerrado', 7, 0, EstadoCurso::Cerrado, 100),
    new CursoOnline(311, 'Curso completo', 2, 2, EstadoCurso::Abierto, 200)
]));

mostrar(
    'Opciones con precios y orden diferentes',
    fn (): array => $alternativo->buscarOpciones(2, 1800)
);

mostrar('Plazas ocupadas tras las búsquedas', function () use ($repository): array {
    $ocupadas = [];

    foreach ($repository->todos() as $curso) {
        $ocupadas[$curso->id()] = $curso->ocupadas();
    }

    return $ocupadas;
});

$consultar = function (
    string $texto = '',
    ?EstadoCurso $estado = null,
    bool $soloConPlazas = false,
    string $prefijo = 'Curso: '
) use ($service): array {
    $lista = $service->ordenar($service->filtrar($texto, $estado, $soloConPlazas));

    return [
        'etiquetas' => $service->etiquetas($lista, $prefijo),
        'resumen' => $service->resumen($lista)
    ];
};

mostrar('Sin filtros', fn (): array => $consultar());

mostrar('Solo con plazas', fn (): array => $consultar(soloConPlazas: true));

mostrar('Texto FOTOGRAFÍA', fn (): array => $consultar('  FOTOGRAFÍA  ', prefijo: 'Taller: '));

mostrar('Estado cerrado', fn (): array => $consultar(estado: EstadoCurso::Cerrado));

mostrar('Cerrado y solo con plazas', fn (): array => $consultar(estado: EstadoCurso::Cerrado, soloConPlazas: true));

mostrar('Texto VÍDEO', fn (): array => $consultar('  VÍDEO  '));

mostrar('Sin coincidencias', fn (): array => $consultar('xyz'));

$operaciones = [
    ['reservar', 201, 2],
    ['reservar', 202, 1],
    ['reservar', 203, 1],
    ['cancelar', 203, 1],
    ['reservar', 201, 4],
    ['cancelar', 201, 5],
    ['reservar', 201, 0],
    ['cancelar', 204, 1],
    ['reservar', 204, 5],
];

foreach ($operaciones as $posicion => [$accion, $id, $cantidad]) {
    mostrar(
        'Operación ' . ($posicion + 1) . ': ' . $accion . ' ' . $cantidad . ' en ' . $id,
        function () use ($service, $accion, $id, $cantidad): string {
            $service->$accion($id, $cantidad);

            return 'Operación realizada';
        }
    );

    $curso = $repository->buscarPorId($id);
    echo 'Ocupadas: ', $curso->ocupadas(), '; libres: ', $curso->plazasLibres(), "\n";
}

mostrar('Catálogo final', fn (): array => $consultar());

mostrar('Solo con plazas al final', fn (): array => $consultar(soloConPlazas: true));
