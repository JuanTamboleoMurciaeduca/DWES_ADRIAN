<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Central de reservas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body><main>
<header><p class="ceja">CENTRO CULTURAL · ACTIVIDADES</p>
<h1>Central de reservas</h1>
<p>Consulta los talleres y simula una reserva o una cancelación.</p></header>
<p class="nota">Los cambios corresponden a esta petición. Cada nueva petición parte de los datos iniciales.</p>
<?php foreach ($avisos as $aviso): ?><p class="aviso"><?= e($aviso) ?></p><?php endforeach; ?>
<?php if ($mensaje !== ''): ?><p class="exito" role="status"><?= e($mensaje) ?></p><?php endif; ?>
<?php if ($error !== ''): ?><p class="error" role="alert"><?= e($error) ?></p><?php endif; ?>
<?php if ($cierre !== ''): ?><p class="cierre"><?= e($cierre) ?></p><?php endif; ?>

<section><h2>Consultar actividades</h2>
<form method="get" class="filtros">
<label>Nombre<input name="q" value="<?= e($texto) ?>" placeholder="Busca una actividad"></label>
<label>Tipo<select name="tipo"><option value="">Todos</option>
<?php foreach (['gratuita' => 'Gratuita', 'pago' => 'De pago'] as $valor => $rotulo): ?>
<option value="<?= e($valor) ?>" <?= $tipo === $valor ? 'selected' : '' ?>><?= e($rotulo) ?></option>
<?php endforeach; ?></select></label>
<label>Estado<select name="estado"><option value="">Todos</option>
<?php foreach (EstadoActividad::cases() as $caso): ?>
<option value="<?= e($caso->value) ?>" <?= $estado === $caso ? 'selected' : '' ?>><?= e(ucfirst($caso->value)) ?></option>
<?php endforeach; ?></select></label>
<label>Orden<select name="orden"><option value="nombre" <?= $orden === 'nombre' ? 'selected' : '' ?>>Nombre</option>
<option value="libres" <?= $orden === 'libres' ? 'selected' : '' ?>>Plazas libres</option></select></label>
<label>Id de ficha<input name="id" value="<?= e($idConsulta) ?>" inputmode="numeric" placeholder="Ejemplo: 103"></label>
<label class="casilla"><input type="checkbox" name="disponibles" value="1" <?= $soloDisponibles ? 'checked' : '' ?>>Solo reservables</label>
<button>Consultar</button><a href="index.php">Restablecer</a>
</form></section>

<section><h2>Resumen del listado visible</h2><dl class="resumen">
<?php foreach (['cantidad' => 'Actividades', 'capacidad' => 'Capacidad', 'ocupadas' => 'Ocupadas', 'libres' => 'Libres'] as $clave => $rotulo): ?>
<div><dt><?= e($rotulo) ?></dt><dd><?= $resumen[$clave] ?></dd></div>
<?php endforeach; ?>
<div><dt>Importe reservado</dt><dd><?= e(euros($resumen['importe'])) ?></dd></div>
</dl><p class="aclaracion">Valor nominal de las plazas ocupadas. Esta simulación no gestiona cobros.</p>
<div class="tabla"><table><thead><tr><th>Id</th><th>Actividad</th><th>Tipo</th><th>Responsable</th><th>Estado</th><th>Cap.</th><th>Ocup.</th><th>Libres</th><th>Precio por plaza</th></tr></thead>
<tbody><?php foreach ($visibles as $a): ?><tr>
<td><?= $a->id() ?></td><td><?= e(limpiarEspacios($a->nombre())) ?></td><td><?= e($a->tipo()) ?></td>
<td><?= e($a->responsable()?->nombre ?? 'Sin responsable') ?></td><td><?= e($a->estado()->value) ?></td>
<td><?= $a->capacidad() ?></td><td><?= $a->ocupadas() ?></td><td><?= $a->plazasLibres() ?></td><td><?= e(euros($a->importe(1))) ?></td>
</tr><?php endforeach; ?></tbody></table></div>
<?php if ($visibles === []): ?><p>No hay actividades que cumplan los filtros.</p><?php endif; ?>
<h3>Etiquetas</h3><ul><?php foreach ($etiquetas as $etiqueta): ?><li><?= e($etiqueta) ?></li><?php endforeach; ?></ul>
</section>

<?php if ($ficha !== null): ?><section><h2>Ficha de la actividad <?= $ficha->id() ?></h2>
<p><?= e(limpiarEspacios($ficha->nombre())) ?> · <?= $ficha->plazasLibres() ?> plazas libres · <?= e($ficha->estado()->value) ?></p>
<p>Responsable: <?= e($ficha->responsable()?->etiqueta('Responsable: ') ?? 'Sin responsable') ?></p>
</section><?php endif; ?>

<section><h2>Simular una operación</h2><form method="get" action="index.php" class="operacion">
<input type="hidden" name="q" value="<?= e($texto) ?>">
<input type="hidden" name="tipo" value="<?= e($tipo) ?>">
<input type="hidden" name="estado" value="<?= e($estadoTexto) ?>">
<input type="hidden" name="orden" value="<?= e($orden) ?>">
<input type="hidden" name="id" value="<?= e($idConsulta) ?>">
<input type="hidden" name="disponibles" value="<?= $soloDisponibles ? '1' : '' ?>">
<label>Acción<select name="accion"><option value="reservar">Reservar</option><option value="cancelar">Cancelar</option></select></label>
<label>Id de actividad<input name="idActividad" inputmode="numeric" required></label>
<label>Plazas<input name="cantidad" inputmode="numeric" required></label><button>Procesar</button>
</form><p class="aclaracion">La operación se busca en el catálogo completo, aunque los filtros oculten la actividad.</p></section>
<footer>DWES · UT2 · PHP y programación orientada a objetos</footer>
</main></body></html>
