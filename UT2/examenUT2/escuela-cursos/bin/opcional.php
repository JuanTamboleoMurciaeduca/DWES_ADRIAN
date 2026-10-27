<?php

declare(strict_types=1);

use Escuela\Curso\Datos\CatalogoInicial;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Repositorio\ArrayCursoRepository;
use Escuela\Curso\Servicio\CatalogoService;

require __DIR__ . '/../vendor/autoload.php';

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

if (!method_exists($service, 'planificarReserva')) {
    echo "Opcional sin implementar.\n";
    exit(0);
}

mostrar('Plan para 9 plazas y 10800 céntimos', fn (): array => $service->planificarReserva(9, 10800));

mostrar('Plan para 11 plazas y 20000 céntimos', fn (): array => $service->planificarReserva(11, 20000));

mostrar('Plan para 9 plazas y 10799 céntimos', fn (): array => $service->planificarReserva(9, 10799));
