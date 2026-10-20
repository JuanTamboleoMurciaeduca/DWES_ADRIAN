<?php
declare(strict_types=1);

// TODO M3. Declara el trait GeneraEtiqueta y su método etiqueta.
trait GeneraEtiqueta{
    public function etiqueta(string $prefijo = ''):string{
        return $prefijo . ': ' . $this->id() . ' · ' . preg_replace( '/\s+/' , ' ',trim($this->nombre()));
    }
}