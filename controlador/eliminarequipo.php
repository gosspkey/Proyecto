<?php
require_once('../confi/conexion.php');
require_once('../modelo/tabletas.php');

// Verificar si se recibió el código del equipo
if (isset($_GET['codigo'])) {
    $codigoEquipo = $_GET['codigo'];

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear una instancia del modelo Tabletas
    $tabletas = new Tabletas($db);

    // Llamar al método para eliminar el equipo
    if ($tabletas->eliminarEquipo($codigoEquipo)) {
        // Redirigir con un mensaje de éxito
        header("Location: ../vista/principal/tablareserv.php?mensaje=Equipo eliminado correctamente");
    } else {
        // Redirigir con un mensaje de error
        header("Location: ../vista/principal/tablareserv.php?mensaje=Error al eliminar el equipo");
    }
} else {
    // Redirigir si no se recibió el código
    header("Location: ../vista/principal/tablareserv.php?mensaje=Código de equipo no proporcionado");
}
?>