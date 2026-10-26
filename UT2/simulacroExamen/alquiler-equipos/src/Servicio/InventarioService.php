<?php

declare(strict_types=1);

namespace Alquiler\Equipo\Servicio;

use Alquiler\Equipo\Contrato\EquipoRepository;
use Alquiler\Equipo\Excepcion\EquipoException;
use Alquiler\Equipo\Modelo\{Equipo, EstadoEquipo};
use Alquiler\Equipo\Repositorio\ArrayEquipoRepository;

final class InventarioService
{
    public function __construct(private EquipoRepository $repository)
    {
    }

    public function filtrar(
        string $texto = '',
        ?EstadoEquipo $estado = null,
        int $minDisponibles = 0
    ): array {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        if ($minDisponibles < 0) {
            throw new \InvalidArgumentException('Mínimo negativo');
        }
        if($estado === EstadoEquipo::EnRevision && $minDisponibles > 0){
            return [];
        }
        // TODO F1: filtra con array_filter y devuelve claves consecutivas.
        return array_values(array_filter(
            $this->repository->todos(), 
            fn(Equipo $e): bool =>
                ($texto === '' || str_contains($e->nombreNormalizado(), $texto)) &&
                (is_null($estado) || $e->estado() === $estado) &&
                ($minDisponibles === 0 || $e->estado() === EstadoEquipo::Disponible && $e->disponibles() >= $minDisponibles)
        ));
    }

    public function ordenar(array $equipos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        $copia = $equipos;
        usort(
            $copia, 
            fn(Equipo $a, Equipo $b):int =>
                [$b->disponibles(), $a->tarifaDia()] <=> [$a->disponibles(), $b->tarifaDia()]
        );
        return $copia;
    }

    public function fichas(array $equipos, string $prefijo = 'Equipo: '): array
    {
        // TODO F3: utiliza array_map y una arrow function.
        return array_map(
            fn(Equipo $e):string => $e->ficha($prefijo), 
            $equipos
        );
    }

    public function resumen(array $equipos): array
    {
        // TODO F4: acumula las tres cifras mediante array_reduce.
        return array_reduce(
            $equipos, 
            function(array $carry, Equipo $item){
                $carry['unidades'] += $item->unidades();
                $carry['reservadas'] += $item->reservadas();
                $carry['valorDisponibleCentimos'] += ($item->disponibles() * $item->tarifaDia());
                return $carry;
            },
            ['unidades' => 0, 'reservadas' => 0, 'valorDisponibleCentimos' => 0]
        );
    }

    public function presupuestarLotes(
        int $cantidad,
        int $dias,
        int $presupuestoCentimos
    ): array {
        // TODO D1: repara las etapas conservando las funciones de arrays.
        if ($cantidad <= 0 || $dias <= 0 || $presupuestoCentimos < 0) {
            throw new \InvalidArgumentException('Cantidad, días o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn (Equipo $equipo): bool =>
                $equipo->estado() === EstadoEquipo::Disponible
                && $equipo->disponibles() >= $cantidad
        );

        $propuestas = array_map(
            fn (Equipo $equipo): array => [
                'id' => $equipo->id(),
                'importeCentimos' => $cantidad * $dias * $equipo->tarifaDia(),
                'disponiblesDespues' => $equipo->disponibles() - $cantidad
            ],
            $candidatos
        );

        $opciones = array_reduce(
            $propuestas,
            function (array $resultado, array $propuesta) use ($presupuestoCentimos): array {
                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $resultado[] = $propuesta;
                }

                return $resultado;
            },
            []
        );

        usort(
            $opciones,
            fn (array $a, array $b): int =>
                [$a['importeCentimos'], $a['id']] <=> [$b['importeCentimos'], $b['id']]
        );

        return $opciones;
    }

    private function requerido(int $id): Equipo
    {
        return $this->repository->buscarPorId($id)
            ?? throw new EquipoException('El equipo no existe');
    }

    public function reservar(int $id, int $cantidad): void
    {
        $this->requerido($id)->reservar($cantidad);
    }

    public function devolver(int $id, int $cantidad): void
    {
        $this->requerido($id)->devolver($cantidad);
    }
}
