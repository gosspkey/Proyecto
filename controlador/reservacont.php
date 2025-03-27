<?php
require_once('../confi/conexion.php');
require_once('../modelo/reservas.php');
require_once('../modelo/tabletas.php');
require_once('../modelo/usuario.php');

session_start(); // Iniciar la sesión

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Depuración
if (!isset($_SESSION['id'])) {
    echo "Error: No se ha iniciado sesión o el ID del usuario no está disponible.";
    exit;
}

echo "ID del usuario en sesión: " . $_SESSION['id']; // Depuración para verificar el ID del usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id']; // ID del usuario desde la sesión
    $CodEquipo = $_POST['CodEquipo'] ?? null; // Código de la tableta seleccionada
    $Fichausu = $_POST['fichausu'] ?? null; // Ficha del usuario
    $FechaReserva = $_POST['FechaReserva'] ?? null; // Fecha de la reserva

    // Validar que los datos requeridos estén presentes
    if (!$id || !$CodEquipo || !$Fichausu || !$FechaReserva) {
        echo "Faltan datos para realizar la reserva.";
        exit;
    }

    // Crear una instancia de la clase Reservas
    $reserva = new Reservas($db);
    $reserva->IDUsuario = $id;
    $reserva->CodEquipo = $CodEquipo;
    $reserva->fichausu = $Fichausu;
    $reserva->FechaReserva = $FechaReserva;

    var_dump($reserva);

// Crear la reserva
if ($reserva->crearReserva()) {
    echo "Reserva registrada correctamente.<br>";

    // Eliminar la tableta de la base de datos
    if ($reserva->eliminarEquipo()) {
        echo "Tableta eliminada correctamente de la base de datos.<br>";
    } else {
        echo "Error al eliminar la tableta.<br>";
    }

    // Redirigir al usuario después de la reserva
    header("Location: ../vista/principal/r-table.php");
    exit;
} else {
    echo "Error al registrar la reserva.";
}
}
?>