<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/cargar.php';
require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$actividades = crearActividades();
$avisos = [];
$mensaje = '';
$error = '';
$cierre = '';

// INICIO E1
// TODO E1. Lee y valida los filtros como indica el apartado 7.
$texto = entrada($_GET, 'q');
$tipo = entrada($_GET, 'tipo');
$estadoTexto = entrada($_GET, 'estado');
$soloDisponibles = entrada($_GET, 'disponibles') === '1';
$orden = entrada($_GET, 'orden', 'nombre');
$idConsulta = entrada($_GET, 'id');

if(!in_array($tipo, ['', 'gratuita', 'pago'])){
    $avisos[]= 'Tipo no valido';
    $tipo = '';
}
if(!is_string($estadoTexto)){
    $avisos[] = 'Estado no valido';
    $estadoTexto = '';
}
$estado = EstadoActividad::tryFrom($estadoTexto);
if(!in_array($orden, ['nombre', 'libres'])){
    $orden = 'nombre';
}

// FIN E1

if (isset($_GET['accion'])) {
    // INICIO E2
    // TODO E2. Procesa la operación y captura las excepciones como indica el apartado 7.
    try{
        $accion = entrada($_GET, 'accion');
        if(!in_array($accion, ['reservar', 'cancelar']))
            throw new InvalidArgumentException('Accion no valida');
        $idActividad = enteroPositivo(entrada($_GET, 'idActividad'));
        $cantidad = enteroPositivo(entrada($_GET, 'cantidad'));
        $actividadBuscada = buscarPorId($actividades, $idActividad);

        is_null($actividadBuscada) ? (throw new ReservaException('Actividad no encontrada')) : ($actividadBuscada->importe($cantidad));

       if($accion === 'reservar'){
            $actividadBuscada->reservar($cantidad);
            $mensaje = 'Reserva realizada. Importe:  ' . euros($actividadBuscada->importe($cantidad));
       } else {
            $actividadBuscada->cancelar($cantidad);
            $mensaje = 'Cancelación realizada. Importe:  ' . euros($actividadBuscada->importe($cantidad));
       }
    }catch(PlazasInsuficientesException $e){
        $error = $e->getMessage();
    }catch(ReservaException $e){
        $error = $e->getMessage();
    }catch(InvalidArgumentException $e){
        $error = $e->getMessage();
    }
    finally{
        $cierre = 'Procesamiento de la operación finalizado';
    }
    // FIN E2
}

// INICIO E3
// TODO E3. Consulta la ficha y prepara el listado, el resumen y las etiquetas.
$ficha = null;
if($idConsulta !== ''){
    try{
    $idFicha = enteroPositivo($idConsulta);
    $ficha = buscarPorId($actividades, $idFicha) ?? throw new InvalidArgumentException('No existe la actividad de la ficha');
        
    }catch(InvalidArgumentException $e){
        $avisos[] = $e->getMessage();
    }

}

$visibles = ordenarActividades(filtrarActividades($actividades, $texto, $tipo, $estado, $soloDisponibles), $orden);
$resumen = resumirActividades($visibles);
$etiquetas = generarEtiquetas($visibles);
// FIN E3

require __DIR__ . '/../vista/catalogo.php';
