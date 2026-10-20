<?php
declare(strict_types=1);

// TODO M6. Implementa la clase abstracta Actividad, sus reglas y las operaciones final.
abstract class Actividad implements Reservable{
    use GeneraEtiqueta;

    public function __construct(
        private readonly int $id, 
        private readonly string $nombre,
        private readonly int $capacidad,
        private int $ocupadas,
        private readonly EstadoActividad $estado,
        private readonly ?Responsable $responsable
    )
    {
        if($this->id < 0){
            throw new InvalidArgumentException('El identificador debe ser un valor positivo');
        }
        if(trim($this->nombre)=== ''){
            throw new InvalidArgumentException('El nombre es obligatorio');
        }
        if($this->capacidad < 0 || !is_int($capacidad)){
            throw new InvalidArgumentException('La capacidad debe de ser un valor entero positivo');
        }
        if($this->$ocupadas < 0){
            throw new InvalidArgumentException('La cantidad de plazas ocupadas debe de ser un valor positivo');
        }
        if($this->ocupadas > $this->capacidad){
            throw new InvalidArgumentException('Las plazas ocupadas no pueden superar a la capacidad total');
        }
    }

    public function id(): int{
        return $this->id;
    }
    public function nombre(): string{
        return $this->nombre;
    }
    public function capacidad(): int{
        return $this->capacidad;
    }
    public function ocupadas(): int{
        return $this->ocupadas;
    }
    public function estado(): EstadoActividad{
        return $this->estado;
    }
    public function responsable(): ?Responsable{
        return $this->responsable;
    }

    public function plazasLibres(): int
    {
        return $this->capacidad - $this->ocupadas;
    }

    public abstract function tipo():string;
    public abstract function importe(int $cantidad): int;

    public function reservar(int $cantidad): void
    {
        if($cantidad <= 0){
            throw new InvalidArgumentException('La cantidad a reservar debe de ser mayor o igual a 0');
        }
        if($this->estado()::Cerrada){
            throw new ReservaException('No se puede reservar una actividad cerrada');
        }
        if($cantidad > $this->plazasLibres()){
            throw new PlazasInsuficientesException('No hay suficientes plazas');
        }
        $this->ocupadas++;
    }

    
    public function cancelar(int $cantidad): void
    {
        if($cantidad <= 0){
            throw new InvalidArgumentException('La cantidad indicada debe de ser mayor que 0');
        }
        if($cantidad > $this->ocupadas()){
            throw new ReservaException('No se pueden reservar mas plazas de las ocupadas');
        }
        $this->ocupadas -= $cantidad;
    }
}