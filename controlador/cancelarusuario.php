<?php
require_once('../confi/conexion.php');

// Verificar si se recibió el ID de la reserva
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Verificar que la reserva pertenece al usuario actual
    session_start();
    $idUsuario = $_SESSION['id']; // ID del usuario en sesión

    $query = "SELECT * FROM Reservas WHERE IDReserva = :idReserva AND IDUsuario = :idUsuario";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Si la reserva pertenece al usuario, eliminarla
        $queryDelete = "DELETE FROM Reservas WHERE IDReserva = :idReserva";
        $stmtDelete = $db->prepare($queryDelete);
        $stmtDelete->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);

        if ($stmtDelete->execute()) {
            header("Location: ../vista/principal/r-table.php?mensaje=Reserva cancelada correctamente");
        } else {
            header("Location: ../vista/principal/r-table.php?mensaje=Error al cancelar la reserva");
        }
    } else {
        // Si la reserva no pertenece al usuario, mostrar un mensaje de error
        header("Location: ../vista/principal/r-table.php?mensaje=No tienes permiso para cancelar esta reserva");
    }
} else {
    header("Location: ../vista/principal/r-table.php?mensaje=ID de reserva no proporcionado");
}
?>