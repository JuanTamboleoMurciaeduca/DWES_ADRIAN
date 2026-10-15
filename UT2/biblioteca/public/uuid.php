<?php
use Ramsey\Uuid\Uuid;
require_once __DIR__ . '/../vendor/autoload.php';
$identificador = Uuid::uuid4();
echo $identificador->toString() . PHP_EOL;