<?php
require_once('../confi/conexion.php');
require_once('../modelo/reservas.php');
require_once('../modelo/tabletas.php');
require_once('../modelo/usuario.php');

session_start(); // iniciar la sesión

// conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// depuracion
if (!isset($_SESSION['id'])) {
    echo "Error: No se ha iniciado sesión o el ID del usuario no está disponible.";
    exit;
}

echo "ID del usuario en sesión: " . $_SESSION['id']; // Depuración para verificar el id del usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id']; // id del usuario desde la sesión
    $CodEquipo = $_POST['CodEquipo'] ?? null; // codigo de la tableta seleccionada
    $Fichausu = $_POST['fichausu'] ?? null; // ficha del usuario
    $FechaReserva = $_POST['FechaReserva'] ?? null; // fecha de la reserva

    // valores recibidos
    var_dump($id, $CodEquipo, $Fichausu, $FechaReserva);

    // Validar que los datos requeridos estén presentes
    if (!$id || !$CodEquipo || !$Fichausu || !$FechaReserva) {
        echo "Faltan datos para realizar la reserva.";
        exit;
    }

    // Preparar la consulta para insertar la reserva
    $query = "INSERT INTO Reservas (IDUsuario, CodEquipo, Fichausu, FechaReserva) 
              VALUES (:IDUsuario, :CodEquipo, :Fichausu, :FechaReserva)";
    $stmt = $db->prepare($query);

    // Vincular los parámetros correctamente
    $stmt->bindValue(':IDUsuario', $id, PDO::PARAM_INT);
    $stmt->bindValue(':CodEquipo', $CodEquipo, PDO::PARAM_INT);
    $stmt->bindValue(':Fichausu', $Fichausu, PDO::PARAM_STR);
    $stmt->bindValue(':FechaReserva', $FechaReserva, PDO::PARAM_STR);

    try {
        $stmt->execute();
        echo "Reserva registrada correctamente.";
    } catch (Exception $e) {
        echo "Error al realizar la reserva: " . $e->getMessage();
    }
}
?>