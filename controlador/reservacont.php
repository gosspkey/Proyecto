<?php
require_once('../confi/conexion.php');
require_once('../modelo/reservas.php');
require_once('../modelo/tabletas.php');
require_once('../modelo/usuario.php');


session_start(); // Asegura que los datos de la sesión estén disponibles

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id']; // ID del usuario desde la sesión
    $CodEquipo = $_POST['CodEquipo'] ?? null; // Código de la tableta seleccionada
    $fichausu = $_POST['fichausu'] ?? null; // Número de ficha del usuario
    $FechaReserva = $_POST['FechaReserva']; // Fecha de la reserva
  
  
  $query = "INSERT INTO Reservas (IDUsuario, CodEquipo, FechaReserva) 
    VALUES (:IDUsuario, :CodEquipo, :FechaReserva)";
$stmt = $db->prepare($query);
$stmt->bindParam(':IDUsuario', $IDUsuario);
$stmt->bindParam(':CodEquipo', $CodEquipo);
$stmt->bindParam(':fichausu', $fichausu);
$stmt->bindParam(':FechaReserva', $FechaReserva);
$stmt->execute();

    if (!$IDUsuario || !$CodEquipo) {
        echo "Faltan datos para realizar la reserva.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    // Instancia de reserva
    $reserva = new Reservas($db);
    $reserva->IDUsuario = $IDUsuario;
    $reserva->CodEquipo = $CodEquipo;

    // Instancia para eliminar la tableta
    $tableta = new Tabletas($db);
    $tableta->id = $CodEquipo;

    // Procesar la reserva
    if ($reserva->crearReserva() && $tableta->eliminarEquipo()) {
        echo "Reserva registrada correctamente.";

        // Notificación al administrador (alerta o correo)
        $mensaje = "El aprendiz $nombreUsuario ha reservado la tableta con ID $CodEquipo.";
        echo "<script>alert('$mensaje');</script>";

    } else {
        echo "Error al procesar la reserva.";
    }
}
?>
