<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Modelo\Envio;
use App\Contrato\RepositorioEnvios;
use App\Exception\EnvioException;
use App\Modelo\EstadoEnvio;
use InvalidArgumentException;

class ServicioEnvios
{
    public function __construct(private RepositorioEnvios $repositorio) {}
    private function obtener(int $id): Envio
    {
        if ($id <= 0) {
            throw new EnvioException('El id debe ser un valor entero positivo');
        }
        return $this->repositorio->buscar($id);
    }

    public function enviar(int $id): void
    {
        if ($id <= 0) {
            throw new EnvioException('El id debe de ser un valor entero positivo');
        }
        $this->obtener($id)->enviar();
    }
    public function entregar(int $id): void
    {
        if ($id <= 0) {
            throw new EnvioException('El id debe de ser un valor entero positivo');
        }
        $this->obtener($id)->entregar();
    }
    public function cancelar(int $id): void
    {
        if ($id <= 0) {
            throw new EnvioException('El id debe de ser un valor entero positivo');
        }
        $this->obtener($id)->cancelar();
    }

    public function consultar(string $texto = '', ?string $modalidad = null, ?EstadoEnvio $estado = null, string $orden = 'precio'): array
    {
        if ($modalidad !== 'normal' || $modalidad !== 'urgente') {
            throw new InvalidArgumentException('Modalidad no valida');
        }
        if ($orden !== 'precio' || $orden !== 'peso') {
            throw new InvalidArgumentException('Modalidad no valida');
        }
        if ($this->repositorio === '') {
            throw new InvalidArgumentException('El repositorio no contiene envios');
        }

        $consultado = array_filter(
            $this->repositorio->todos(),
            fn(Envio $e): bool => ($texto === '' || str_contains($this->normalizar($texto), $e->cliente())) &&
                (is_null($modalidad) || $e->modalidad() === $this->normalizar($modalidad)) &&
                (is_null($estado) || $e->estado() === $estado)
        );
        $orden === 'precio' ?
            usort(
                $consultado,
                fn(Envio $a, Envio $b): int => [$a->tarifa(), $a->id()] <=> [$b->tarifa(), $b->id()]
            ) :
            usort(
                $consultado,
                fn(Envio $a, Envio $b): int => [$a->peso(), $a->id()] <=> [$b->peso(), $b->id()]
            );
        return $consultado;
    }

    private static function normalizar(string $texto): string
    {
        return mb_strtolower(preg_replace('/\s+/', ' ', trim($texto)), 'UTF-8');
    }
    public function etiquetas(array $envios): array
    {
        return array_map(
            fn(Envio $e): string => 'Id: ' . $e->id() . ' · Cliente: ' . $e->cliente() . ' · Modalidad: ' . $e->modalidad() . ' · Estado: ' . $e->estado() . ' · Tarifa: ' . $e->tarifa() . '€',
            $envios
        );
    }

    public function resumir(array $envios)
    {
        return array_reduce(
            $envios,
            function (array $carry, Envio $item) use ($envios) {
                $carry['cantidad'] += count($envios);
                $carry['peso'] += $item->peso();
                $carry['importeTotal'] += $item->tarifa();
                if ($item->estado() !== 'cancelado') {
                    $carry['importeActivo'] += $item->tarifa();
                }
                $carry[$item->estado()->value] += 1;
            },
            ['cantidad' => 0, 'peso' => 0, 'importeTotal' => 0, 'importeActivo' => 0, 'pendiente' => 0, 'enviado' => 0, 'entregado' => 0, 'cancelado' => 0]
        );
    }
}
