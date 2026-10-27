<?php

declare(strict_types=1);

namespace Escuela\Curso\Servicio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{Curso, EstadoCurso};
use InvalidArgumentException;

final class CatalogoService
{
    public function __construct(private CursoRepository $repository) {}

    public function filtrar(
        string $texto = '',
        ?EstadoCurso $estado = null,
        bool $soloConPlazas = false
    ): array {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        // TODO F1: filtra los cursos mediante array_filter.
        return array_values(array_filter(
            $this->repository->todos(),
            fn(Curso $c): bool => (str_contains($c->nombreNormalizado(), $texto)) &&
                (is_null($estado) || $estado === $c->estado()) &&
                // Aquí estaba tu fallo
                (!$soloConPlazas || ($c->estado() === EstadoCurso::Abierto && $c->plazasLibres() > 0))
        ));
    }

    public function ordenar(array $cursos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        $copia = $cursos;

        usort(
            $copia,
            fn(Curso $a, Curso $b): int =>
            [$a->precioPlaza(), $a->id()] <=> [$b->precioPlaza(), $b->id()]
        );
        return $copia;
    }

    public function etiquetas(array $cursos, string $prefijo = 'Curso: '): array
    {
        // TODO F3: array_map y arrow function.
        return array_map(
            // Para algo hemos hecho la función etiqueta, no?
            fn(Curso $c): string => $c->etiqueta($prefijo),
            $cursos
        );
    }

    public function resumen(array $cursos): array
    {
        // TODO F4: calcula las tres cifras mediante array_reduce.
        return array_reduce(
            $cursos,
            function (array $carry, Curso $item) {
                $carry['cantidad']++;
                $carry['libres'] += $item->plazasLibres();
                $carry['importeCentimos'] += ($item->ocupadas() * $item->precioPlaza());
                return $carry;
            },
            ['cantidad' => 0, 'libres' => 0, 'importeCentimos' => 0]
        );
    }

    public function buscarOpciones(int $plazas, int $presupuestoCentimos): array
    {
        // TODO D1: repara las etapas de esta búsqueda sin utilizar bucles.
        if ($plazas <= 0 || $presupuestoCentimos < 0) {
            throw new \InvalidArgumentException('Plazas o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn(Curso $curso): bool =>
            $curso->estado() === EstadoCurso::Abierto
                && $curso->plazasLibres() >= $plazas
        );

        $propuestas = array_map(
            fn(Curso $curso): array => [
                'id' => $curso->id(),
                'importeCentimos' => $curso->precioPlaza() * $plazas,
                'libresDespues' => $curso->plazasLibres() - $plazas
            ],
            $candidatos
        );

        $resultado = array_reduce(
            $propuestas,
            function (array $acumulado, array $propuesta) use ($presupuestoCentimos): array {

                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $acumulado[] = $propuesta;
                }

                return $acumulado;
            },
            []
        );

        // Ordenas propuestas en lugar de resultado
        usort(
            $resultado,
            fn(array $a, array $b): int => (($a['importeCentimos'] <=> $b['importeCentimos']) !== 0)
                ? ($a['importeCentimos'] <=> $b['importeCentimos'])
                : ($a['id'] <=> $b['id'])
        );

        return $resultado;
    }

    private function requerido(int $id): Curso
    {
        return $this->repository->buscarPorId($id)
            ?? throw new CursoException('El curso no existe');
    }

    public function reservar(int $id, int $cantidad): void
    {
        $this->requerido($id)->reservar($cantidad);
    }

    public function cancelar(int $id, int $cantidad): void
    {
        $this->requerido($id)->cancelar($cantidad);
    }

    //Ejercicio 8
    // public function planificarReserva(
    //     int $plazas, 
    //     int $presupuestoCentimos
    // ): array
    // {
    //     if($plazas <= 0 || $presupuestoCentimos < 0){
    //         throw new InvalidArgumentException('Numero de plazas o presupuesto incorrectos');
    //     }

    // }
}
