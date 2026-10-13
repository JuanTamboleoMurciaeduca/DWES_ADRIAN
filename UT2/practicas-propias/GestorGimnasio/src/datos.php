<?php
// Array multidimensional de actividades del gimnasio
$actividades = [
    101 => ['nombre' => 'Spinning', 'capacidad' => 20],
    102 => ['nombre' => 'Crossfit Titan', 'capacidad' => 15],
    103 => ['nombre' => 'Yoga', 'capacidad' => 12],
    104 => ['nombre' => 'Pilates', 'capacidad' => 10]
];

// Array asociativo de reservas actuales (id_actividad => numero_de_reservas)
$reservas = [
    101 => 20, // Lleno
    102 => 8,
    103 => 4,
    104 => 0
];