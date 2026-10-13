<?php
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

// =========================================================================
// TODO 1: Recogida de datos
// Lee el parámetro GET 'q' (búsqueda). Si no existe, asigna cadena vacía.
// Lee el parámetro GET 'estado'. Si no existe, asigna 'todas'.

$busqueda = (isset($_GET['q']) && is_string($_GET['q'])) ? normalizarTexto($_GET['q']) : '';
$estado = (isset($_GET['estado']) && is_string($_GET['estado'])) ? normalizarTexto($_GET['estado']) : 'todas';

// TODO 2: Validación
// Valida que 'estado' solo pueda ser 'todas' o 'disponibles'. 
// Si es un valor distinto, asígnale 'todas'.

if($estado !== 'todas' && $estado !== 'disponibles'){
    $estado = 'todas';
}


// TODO 3: Llamada a funciones
// Llama a filtrarActividades() pasándole $actividades, la búsqueda y el estado validado.
// Guarda el resultado en $actividadesVisibles para que la vista pueda iterar sobre él.
$actividadesVisibles = filtrarActividades($actividades, $busqueda, $estado); // Reemplaza esto con tu código

// =========================================================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gimnasio Titan - Clases</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gimnasio Titan</h1>
        <nav>
            <a href="index.php">Listado (Arrays)</a>
            <a href="ampliacion.php">Ampliación (POO)</a>
        </nav>
    </header>

    <main>
        <h2>Buscador de Actividades</h2>
        <form method="GET" action="index.php" class="buscador">
            <input type="text" name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" placeholder="Buscar clase...">
            <select name="estado">
                <option value="todas">Todas</option>
                <option value="disponibles">Solo con plazas</option>
            </select>
            <button type="submit">Buscar</button>
        </form>

        <div class="grid-clases">
            <?php if (empty($actividadesVisibles)): ?>
                <p>No se encontraron actividades.</p>
            <?php else: ?>
                <?php foreach ($actividadesVisibles as $id => $act): ?>
                    <?php 
                    $ocupadas = $reservas[$id] ?? 0;
                    // Llama a la función que debes reparar en funciones.php
                    $libres = calcularDisponibles($act['capacidad'], $ocupadas);
                    $claseEstado = $libres === 0 ? 'agotado' : 'disponible';
                    ?>
                    <div class="tarjeta <?= $claseEstado ?>">
                        <h3><?= htmlspecialchars($act['nombre']) ?></h3>
                        <p>ID: <?= $id ?></p>
                        <p>Plazas Libres: <strong><?= $libres ?> / <?= $act['capacidad'] ?></strong></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
<?php
require_once __DIR__ . '/../templates/ampliacion.php';