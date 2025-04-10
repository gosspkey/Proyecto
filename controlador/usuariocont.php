<?php

require_once __DIR__ . '/../confi/conexion.php';
session_start(); // Asegúrate de iniciar sesión

// Obtener la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Obtener datos del formulario
$usuario = $_POST['usuario'];  // Corregido
$contra = $_POST['contraseña'];

// --- Verificar en Usuario
$sql = "SELECT * FROM Usuario WHERE Usuario = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$usuario]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if ($datos && password_verify($contra, $datos['Contraseña'])) {
    $_SESSION['rol'] = 'aprendiz';
    $_SESSION['Idusu'] = $datos['Idusu'];
    header("Location: aprendiz/../../vista/principal/equipos.html");
    exit();
}

// --- Verificar en Instructores
$sql = "SELECT * FROM Instructores WHERE Usuario = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$usuario]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if ($datos && password_verify($contra, $datos['Contraseña'])) {
    $_SESSION['rol'] = 'instructor';
    $_SESSION['nombre'] = $datos['Nombreins'];
    header("Location: instructor/../../vista/principal/equipos.html");
    exit();
}

// --- Verificar en Administradores
$sql = "SELECT * FROM Administradores WHERE Usuario = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$usuario]);
$datos = $stmt->fetch(PDO::FETCH_ASSOC);

if ($datos && password_verify($contra, $datos['Contraseña'])) {
    $_SESSION['rol'] = 'admin';
    $_SESSION['nombre'] = $datos['Nombread'];
    header("Location: admin/../../vista/principal/admin.html");
    exit();
}

// --- Si no se encuentra el usuario
echo "Usuario o contraseña incorrectos.";

?>
