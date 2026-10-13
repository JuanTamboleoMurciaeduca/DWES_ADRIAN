<?php
require_once __DIR__ . '/../src/datos.php';
// Requiere la clase que tú vas a programar:
require_once __DIR__ . './Sesion.php'; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ampliación POO - Gimnasio Titan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gimnasio Titan (POO)</h1>
        <nav>
            <a href="index.php">Listado (Arrays)</a>
            <a href="ampliacion.php">Ampliación (POO)</a>
        </nav>
    </header>

    <main>
        <h2>Conversión a Objetos</h2>
        <p>A continuación se instancian los datos usando la clase <code>Sesion</code>.</p>
        
        <div class="grid-clases">
            <?php 
            foreach ($actividades as $id => $datosArray) {
                try {
                    $ocupadas = $reservas[$id] ?? 0;
                    
                    // Aquí es donde instanciamos la clase que has creado
                    $sesionObj = new Sesion(
                        $datosArray['nombre'], 
                        $datosArray['capacidad'], 
                        $ocupadas
                    );

                    $libres = $sesionObj->plazasLibres();
                    $claseEstado = $libres === 0 ? 'agotado' : 'disponible';
                    ?>
                    
                    <div class="tarjeta <?= $claseEstado ?>">
                        <h3><?= htmlspecialchars($sesionObj->nombre) ?></h3>
                        <p>Estado del objeto: <em>Válido</em></p>
                        <p>Plazas Libres (Método): <strong><?= $libres ?> / <?= $sesionObj->capacidadMax ?></strong></p>
                    </div>

                    <?php
                } catch (InvalidArgumentException $e) {
                    echo "<div class='tarjeta error'>";
                    echo "<h3>Error al crear objeto</h3>";
                    echo "<p>" . $e->getMessage() . "</p>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </main>
</body>
</html>