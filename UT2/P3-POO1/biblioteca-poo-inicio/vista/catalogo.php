<?php
// HTML facilitado. Recibe las variables preparadas en public/index.php.
// Se usa htmlspecialchars para mostrar texto sin interpretarlo como HTML.
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca en memoria</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
<main class="contenedor">
    <header class="cabecera">
        <p class="antetitulo">Biblioteca en memoria</p>
        <h1>Catálogo y préstamos</h1>
        <p>Consulta los libros y observa el estado de sus ejemplares.</p>
    </header>
    <section class="resumen" aria-label="Resumen del catálogo completo">
        <article><span>Libros</span><strong><?= (int) $resumen['total'] ?></strong></article>
        <article><span>Disponibles</span><strong><?= (int) $resumen['disponibles'] ?></strong></article>
        <article><span>Páginas</span><strong><?= (int) $resumen['paginas'] ?></strong></article>
    </section>
    <section class="panel" aria-labelledby="titulo-catalogo">
        <h2 id="titulo-catalogo">Consulta del catálogo</h2>
        <form method="get" action="index.php" class="filtros">
            <div>
                <label for="q">Título</label>
                <input id="q" name="q" type="search" placeholder="Buscar un título"
                       value="<?= e($entradaBusqueda) ?>">
            </div>
            <div>
                <label for="orden">Ordenar por</label>
                <select id="orden" name="orden">
                    <option value="paginas" <?= $orden === 'paginas' ? 'selected' : '' ?>>Páginas</option>
                    <option value="titulo" <?= $orden === 'titulo' ? 'selected' : '' ?>>Título</option>
                </select>
            </div>
            <label class="casilla"><input name="disponibles" type="checkbox" value="1"
                <?= $soloDisponibles ? 'checked' : '' ?>> Solo disponibles</label>
            <button type="submit">Consultar</button>
            <a href="index.php">Restablecer</a>
        </form>
        <p class="nota"><?= count($visibles) ?> libro(s) en esta consulta.</p>
        <?php if ($visibles === []): ?>
            <p class="vacio">No hay libros que coincidan con la consulta.</p>
        <?php else: ?>
            <div class="tabla-contenedor">
                <table>
                    <caption class="solo-lectores">Libros de la consulta actual</caption>
                    <thead><tr><th scope="col">Título</th><th scope="col">Autor</th>
                        <th scope="col">Categoría</th><th scope="col">Páginas</th><th scope="col">Estado</th></tr></thead>
                    <tbody>
                    <?php foreach ($visibles as $libro): ?>
                        <tr>
                            <th scope="row"><?= e($libro->titulo) ?></th>
                            <td><?= e($libro->autor?->nombre ?? 'Sin autor') ?></td>
                            <td><?= e($libro->categoria->nombre) ?></td>
                            <td><?= (int) $libro->paginas ?></td>
                            <td><span class="estado <?= $libro->disponible ? 'disponible' : 'prestado' ?>">
                                <?= $libro->disponible ? 'Disponible' : 'Prestado' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
    <section class="panel" aria-labelledby="titulo-fichas">
        <h2 id="titulo-fichas">Fichas de la consulta</h2>
        <?php if ($etiquetas === []): ?><p class="nota">No hay fichas para mostrar.</p>
        <?php else: ?><ul class="lista">
            <?php foreach ($etiquetas as $etiqueta): ?><li><?= e($etiqueta) ?></li><?php endforeach; ?>
        </ul><?php endif; ?>
    </section>
    <section class="panel" aria-labelledby="titulo-comprobaciones">
        <h2 id="titulo-comprobaciones">Comprobaciones de los objetos</h2>
        <?php if ($mensajes === []): ?><p class="nota">No hay comprobaciones para mostrar.</p>
        <?php else: ?><ul class="lista">
            <?php foreach ($mensajes as $mensaje): ?><li><?= e($mensaje) ?></li><?php endforeach; ?>
        </ul><?php endif; ?>
    </section>
    <footer>La simulación se reinicia al recargar la página.</footer>
</main>
</body>
</html>
