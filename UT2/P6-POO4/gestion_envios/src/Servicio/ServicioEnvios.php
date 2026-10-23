<?php

declare(strict_types=1);

namespace App\Servicio;

use App\Modelo\Envio;
use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use App\Modelo\EstadoEnvio;
use InvalidArgumentException;

class ServicioEnvios
{
    public function __construct(private RepositorioEnvios $repositorio) {}
    private function obtener(int $id): Envio
    {
        if ($this->repositorio->buscar($id) === null) {
            throw new EnvioException('No existe ningún envío con ese id');
        }
        return $this->repositorio->buscar($id);
    }

    public function enviar(int $id): void
    {
        $this->obtener($id)->enviar();
    }
    public function entregar(int $id): void
    {
        $this->obtener($id)->entregar();
    }
    public function cancelar(int $id): void
    {
        $this->obtener($id)->cancelar();
    }

    public function consultar(string $texto = '', ?string $modalidad = null, ?EstadoEnvio $estado = null, string $orden = 'precio'): array
    {
        if ($modalidad !== null && $modalidad !== 'normal' && $modalidad !== 'urgente') {
            throw new InvalidArgumentException('Modalidad no valida');
        }
        if ($orden !== 'precio' && $orden !== 'peso') {
            throw new InvalidArgumentException('Orden no valido');
        }

        $consultado = array_filter(
            $this->repositorio->todos(),
            fn(Envio $e): bool => ($texto === '' || str_contains($this->normalizar($e->cliente()), $this->normalizar($texto))) &&
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
            fn(Envio $e): string => 'Id: ' . $e->id() . ' · Cliente: ' . $e->cliente() . ' · Modalidad: ' . $e->modalidad() . ' · Estado: ' . $e->estado()->value . ' · Tarifa: ' . $e->tarifa() . ' céntimos',
            $envios
        );
    }

    public function resumir(array $envios)
    {
        return array_reduce(
            $envios,
            function (array $carry, Envio $item){
                $carry['cantidad']++;
                $carry['peso'] += $item->peso();
                $carry['importeTotal'] += $item->tarifa();
                if ($item->estado() !== EstadoEnvio::Cancelado) {
                    $carry['importeActivo'] += $item->tarifa();
                }
                $carry[$item->estado()->value] += 1;

                return $carry;
            },
            ['cantidad' => 0, 'peso' => 0, 'importeTotal' => 0, 'importeActivo' => 0, 'pendiente' => 0, 'enviado' => 0, 'entregado' => 0, 'cancelado' => 0]
        );
    }
}
