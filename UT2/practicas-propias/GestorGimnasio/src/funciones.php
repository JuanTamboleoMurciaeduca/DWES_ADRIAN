<?php

// 1. BIEN IMPLEMENTADA
function normalizarTexto(string $texto): string {
    return trim(mb_strtolower($texto, 'UTF-8'));
}

// 2. ERROR DE LÓGICA Y FALTA IMPLEMENTAR EL FILTRO DE ESTADO
function filtrarActividades(array $actividades, string $busqueda, string $estado): array {
    $resultado = [];
    $busquedaLimpia = normalizarTexto($busqueda);
    
    global $reservas; // Importamos reservas temporalmente para poder calcular las plazas aquí
    
    foreach ($actividades as $id => $actividad) {
        // ERROR: Comprueba si NO contiene la cadena
        $coincideTexto = str_contains(normalizarTexto($actividad['nombre']), $busquedaLimpia);
        
        // TODO: Añadir lógica para que, si $estado === 'disponibles', 
        // solo se añadan las actividades donde (capacidad - reservas) > 0
        if($estado === 'disponibles'){
            if(($actividad['capacidad'] - $reservas[$id]) > 0){
                $resultado[$id] = $actividad;
            }
        }
        
        if ($coincideTexto) {
            $resultado[$id] = $actividad;
        }
    }
    return $resultado;
}

// 3. ERRORES DE SINTAXIS
function calcularDisponibles(int $capacidad, int $reservadas): int {
    $disponibles = $capacidad - $reservadas;
    return $disponibles;
}

// 4. SIN IMPLEMENTAR
function buscarActividadPorId(array $actividades, int $id): ?array {
    // TODO: Implementar búsqueda por clave
    $actividadBuscada = array_find($actividades, 
                                    fn(int $i):bool => $i === $id);

    
    return is_null($actividadBuscada) ? null : $actividadBuscada;
}