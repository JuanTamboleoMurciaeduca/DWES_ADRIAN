<?php

declare(strict_types=1);

$cadena = ' DRÁCULA ';

//Primer paso: quitar los espacios exteriores

$cadenaSinEspacios = trim($cadena);
//Mostrar resultado
var_dump($cadenaSinEspacios);

//Segundo paso: convertir la cadena a minusculas manteniendo las tildes

$cadenaNormalizada = mb_strtolower($cadenaSinEspacios, 'UTF-8');
//Resultado

var_dump($cadenaNormalizada);

//Calcular longitud

$longitud = mb_strlen($cadenaNormalizada);

var_dump($longitud);

