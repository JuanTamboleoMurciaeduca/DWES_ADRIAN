<?php

declare(strict_types=1);

use Alquiler\Equipo\Contrato\EquipoRepository;
use Alquiler\Equipo\Datos\CatalogoInicial;
use Alquiler\Equipo\Excepcion\EquipoException;
use Alquiler\Equipo\Modelo\{EquipoFotografia, EquipoSonido, EstadoEquipo};
use Alquiler\Equipo\Repositorio\ArrayEquipoRepository;
use Alquiler\Equipo\Servicio\InventarioService;

$autoload = __DIR__ . '/../vendor/autoload.php';

if (!is_file($autoload)) {
    fwrite(STDERR, "Completa C0 y ejecuta composer dump-autoload.\n");
    exit(1);
}

require $autoload;

if (!class_exists(CatalogoInicial::class)) {
    fwrite(STDERR, "Completa C0: asocia Alquiler\\Equipo\\ con src/ y regenera el autoloader.\n");
    exit(1);
}

function mostrar(string $titulo, callable $accion): void
{
    echo "\n", $titulo, "\n";

    try {
        echo json_encode($accion(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), "\n";
    } catch (\InvalidArgumentException | EquipoException $e) {
        echo 'Rechazo: ', $e->getMessage(), "\n";
    } catch (\LogicException $e) {
        echo $e->getMessage(), "\n";
    }
}

$repository = new ArrayEquipoRepository((new CatalogoInicial())->equipos());
$service = new InventarioService($repository);

echo 'Inventario cargado: ', count($repository->todos()), " equipos.\n";

mostrar('Casos del enum', fn (): array => [
    'disponible' => EstadoEquipo::Disponible->value,
    'revision' => EstadoEquipo::EnRevision->value,
    'valorDesconocido' => EstadoEquipo::tryFrom('retirado') === null
]);

mostrar('Contrato del repositorio', fn (): array => [
    'cumpleContrato' => $repository instanceof EquipoRepository,
    'cantidad' => count($repository->todos()),
    'equipo505' => $repository->buscarPorId(505)->id(),
    'inexistente' => $repository->buscarPorId(999) === null
]);

mostrar('Excepción de dominio', function (): void {
    throw new EquipoException('El equipo no admite reservas');
});

mostrar('Constructor de fotografía con seguro a cero', function (): array {
    $equipo = new EquipoFotografia(601, '  Cámara compacta  ', 4, 1, EstadoEquipo::Disponible, 1000, 0);

    return [
        'id' => $equipo->id(),
        'nombre' => $equipo->nombre(),
        'unidades' => $equipo->unidades(),
        'reservadas' => $equipo->reservadas(),
        'estado' => $equipo->estado()->value,
        'tarifaDia' => $equipo->tarifaDia()
    ];
});

mostrar('Constructor con seguro negativo', function (): void {
    new EquipoFotografia(601, 'Cámara compacta', 4, 1, EstadoEquipo::Disponible, 1000, -1);
});

mostrar('Constructor con más reservadas que unidades', function (): void {
    new EquipoFotografia(601, 'Cámara compacta', 4, 5, EstadoEquipo::Disponible, 1000, 0);
});

mostrar('Lotes de 2 unidades, 3 días y 9000 céntimos', fn (): array => $service->presupuestarLotes(2, 3, 9000));

mostrar('Lotes de 5 unidades, 1 día y 10000 céntimos', fn (): array => $service->presupuestarLotes(5, 1, 10000));

mostrar('Lotes de 8 unidades, 1 día y 50000 céntimos', fn (): array => $service->presupuestarLotes(8, 1, 50000));

mostrar('Lotes con cero días', fn (): array => $service->presupuestarLotes(2, 0, 9000));

$alternativo = new InventarioService(new ArrayEquipoRepository([
    new EquipoSonido(610, 'Auriculares de estudio', 4, 1, EstadoEquipo::Disponible, 600),
    new EquipoFotografia(605, 'Panel LED', 4, 0, EstadoEquipo::Disponible, 500, 100),
    new EquipoSonido(604, 'Grabadora estéreo', 3, 1, EstadoEquipo::Disponible, 500),
    new EquipoSonido(609, 'Micrófono en revisión', 6, 0, EstadoEquipo::EnRevision, 100),
    new EquipoSonido(611, 'Altavoz sin existencias', 2, 2, EstadoEquipo::Disponible, 100)
]));

mostrar(
    'Lotes con precios y orden diferentes',
    fn (): array => $alternativo->presupuestarLotes(2, 2, 2400)
);

mostrar('Unidades reservadas tras los presupuestos', function () use ($repository): array {
    $reservadas = [];

    foreach ($repository->todos() as $equipo) {
        $reservadas[$equipo->id()] = $equipo->reservadas();
    }

    return $reservadas;
});

$consultar = function (
    string $texto = '',
    ?EstadoEquipo $estado = null,
    int $minDisponibles = 0,
    string $prefijo = 'Equipo: '
) use ($service): array {
    $lista = $service->ordenar($service->filtrar($texto, $estado, $minDisponibles));

    return [
        'fichas' => $service->fichas($lista, $prefijo),
        'resumen' => $service->resumen($lista)
    ];
};

mostrar('Sin filtros', fn (): array => $consultar());

mostrar('Mínimo 4 disponibles', fn (): array => $consultar(minDisponibles: 4));

mostrar('Texto CÁMARA', fn (): array => $consultar('  CÁMARA  ', prefijo: 'Foto: '));

mostrar('Estado en revisión', fn (): array => $consultar(estado: EstadoEquipo::EnRevision));

mostrar('En revisión y mínimo 1 disponible', fn (): array => $consultar(estado: EstadoEquipo::EnRevision, minDisponibles: 1));

mostrar('Texto MICRÓFONO', fn (): array => $consultar('  MICRÓFONO  '));

mostrar('Sin coincidencias', fn (): array => $consultar('xyz'));

$operaciones = [
    ['reservar', 501, 3],
    ['reservar', 502, 1],
    ['reservar', 505, 1],
    ['devolver', 505, 1],
    ['reservar', 501, 3],
    ['devolver', 501, 5],
    ['reservar', 501, 0],
    ['devolver', 504, 2],
    ['reservar', 504, 4],
    ['devolver', 503, 1],
];

foreach ($operaciones as $posicion => [$accion, $id, $cantidad]) {
    mostrar(
        'Operación ' . ($posicion + 1) . ': ' . $accion . ' ' . $cantidad . ' en ' . $id,
        function () use ($service, $accion, $id, $cantidad): string {
            $service->$accion($id, $cantidad);

            return 'Operación realizada';
        }
    );

    $equipo = $repository->buscarPorId($id);
    echo 'Reservadas: ', $equipo->reservadas(), '; disponibles: ', $equipo->disponibles(), "\n";
}

mostrar('Inventario final', fn (): array => $consultar());

mostrar('Mínimo 4 disponibles al final', fn (): array => $consultar(minDisponibles: 4));
