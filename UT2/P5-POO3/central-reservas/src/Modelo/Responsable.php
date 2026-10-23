<?php
declare(strict_types=1);

// TODO M4. Implementa Responsable final, sus propiedades readonly y el trait.
final class Responsable{
    use GeneraEtiqueta;
    
    public function __construct(public readonly int $id, public readonly string $nombre){
        if($this->id < 0){
            throw new InvalidArgumentException('El identificador debe ser un valor positivo');
        }
        if(trim($this->nombre)=== ''){
            throw new InvalidArgumentException('El nombre es obligatorio');
        }
    }

    public function id(): int{
        return $this->id;
    }
    public function nombre(): string{
        return $this->nombre;
    }
}