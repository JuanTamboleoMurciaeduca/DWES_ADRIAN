<?php
declare(strict_types=1);

// FACILITADO. No hay tareas que completar en este archivo.
require_once __DIR__ . '/../src/cargar.php';

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function mostrarFicha(Juego $juego): void
{
    echo '<p class="ficha">' . e($juego->ficha()) . '</p>';
}

function mostrarError(Exception $error): void
{
    echo '<p class="error">' . e(get_class($error) . ': ' . $error->getMessage()) . '</p>';
}
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Herencia en la ludoteca</title><link rel="stylesheet" href="estilo.css"></head>
<body><main>
<header><h1>Herencia en la ludoteca</h1><p>Clases de juegos y operaciones de préstamo</p></header>
<p class="nota">La página ejecuta siempre la misma secuencia. Al recargar, los objetos se crean de nuevo.</p>
<?php if (!class_exists('JuegoMesa') || !class_exists('Videojuego')): ?>
<section><h2>Proyecto preparado</h2><p>Completa M1 a M6 en los archivos de src y vuelve a abrir esta página. El index ya está resuelto.</p></section>
<?php else:
$mesa = new JuegoMesa(101, 'Catan', 4);
$otro = new JuegoMesa(102, 'Dixit', 6);
$video = new Videojuego(201, 'Mario Kart 8 Deluxe', 'Nintendo Switch');
?>
<section><h2>1. Objetos disponibles</h2>
<?php mostrarFicha($mesa); mostrarFicha($otro); mostrarFicha($video); ?>
<p class="dato">Plazos máximos: <?= $mesa->plazoMaximo() ?> días para JuegoMesa y <?= $video->plazoMaximo() ?> para Videojuego.</p>
</section>
<section><h2>2. Un préstamo y dos referencias</h2>
<?php
$alias = $mesa;
$mesa->prestar(10);
mostrarFicha($alias);
mostrarFicha($otro);
?>
<p class="dato">El alias y Catan son el mismo objeto: <?= $alias === $mesa ? 'Sí' : 'No' ?>.</p>
</section>
<section><h2>3. Renovar hasta el límite</h2>
<?php
$mesa->renovar(4);
mostrarFicha($mesa);
try { $mesa->renovar(1); } catch (Exception $error) { mostrarError($error); }
try { $mesa->prestar(1); } catch (Exception $error) { mostrarError($error); }
try { $mesa->renovar(0); } catch (Exception $error) { mostrarError($error); }
mostrarFicha($mesa);
?>
</section>
<section><h2>4. Un plazo distinto para Videojuego</h2>
<?php
try { $video->prestar(8); } catch (Exception $error) { mostrarError($error); }
mostrarFicha($video);
$video->prestar(7);
try { $video->renovar(1); } catch (Exception $error) { mostrarError($error); }
mostrarFicha($video);
?>
</section>
<section><h2>5. Devolver y volver a prestar</h2>
<?php
$mesa->devolver();
mostrarFicha($mesa);
try { $mesa->devolver(); } catch (Exception $error) { mostrarError($error); }
$mesa->prestar(14);
mostrarFicha($alias);
$video->devolver();
mostrarFicha($video);
mostrarFicha($otro);
?>
</section>
<section><h2>6. Datos inválidos en los constructores</h2>
<?php
try { new JuegoMesa(0, 'Catan', 4); } catch (Exception $error) { mostrarError($error); }
try { new Videojuego(202, '   ', 'PC'); } catch (Exception $error) { mostrarError($error); }
try { new JuegoMesa(103, 'Dixit', 0); } catch (Exception $error) { mostrarError($error); }
try { new Videojuego(203, 'Portal 2', '   '); } catch (Exception $error) { mostrarError($error); }
?>
</section>
<?php endif; ?>
<footer>DWES · UT2 · Herencia y programación orientada a objetos</footer>
</main></body></html>
