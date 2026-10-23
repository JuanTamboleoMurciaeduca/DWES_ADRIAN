<?php
declare(strict_types=1);

// TODO M1. Declara el contrato Reservable con las tres firmas del apartado 2.
interface Reservable{
    public function reservar(int $cantidad): void;
    public function cancelar(int $cantidad): void; 
    public function plazasLibres(): int;
}