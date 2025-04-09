<?php
require_once('../confi/conexion.php');
require_once('../modelo/reservas.php');
require_once('../modelo/tabletas.php');


session_start(); // Iniciar la sesión

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Depuración
if (!isset($_SESSION['Idusu'])) {
    echo "Error: No se ha iniciado sesión o el ID del usuario no está disponible.";
    exit;
}

$Idusu = $_SESSION['Idusu']; // ID del usuario desde la sesión
echo "ID del usuario en sesión: " . $Idusu; // Depuración para verificar el ID del usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $CodEquipo = $_POST['CodEquipo'] ?? null; // Código de la tableta seleccionada
    $Fichausu = $_POST['fichausu'] ?? null; // Ficha del usuario
    $FechaReserva = $_POST['FechaReserva'] ?? null; // Fecha de la reserva

    // Validar que los datos requeridos estén presentes
    if (!$Idusu || !$CodEquipo || !$Fichausu || !$FechaReserva) {
        echo "Faltan datos para realizar la reserva.";
        exit;
    }

    // Crear la reserva
    $query = "INSERT INTO Reservas (IDUsuario, CodEquipo, Fichausu, FechaReserva) VALUES (:Idusu, :CodEquipo, :Fichausu, :FechaReserva)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':Idusu', $Idusu);
    $stmt->bindParam(':CodEquipo', $CodEquipo);
    $stmt->bindParam(':Fichausu', $Fichausu);
    $stmt->bindParam(':FechaReserva', $FechaReserva);

    if ($stmt->execute()) {
        // Obtener el ID de la reserva recién creada
        $idReserva = $db->lastInsertId();

        // Redirigir al usuario después de la reserva
        header("Location: ../vista/principal/reservaexitosa.php?id=$idReserva");
        exit;
    } else {
        echo "Error al registrar la reserva.";
    }
} else {
    echo "Método no permitido.";
}
?>