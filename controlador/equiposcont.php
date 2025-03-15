<?php
require_once('../confi/conexion.php');
require_once('../modelo/tabletas.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Depuración de datos recibidos
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Validar datos del formulario
    if (!isset($_POST['placa'], $_POST['descripcion'], $_POST['tableta'])) {
        echo "Faltan datos en el formulario.";
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();

    $tableta = new Tabletas($db);
    $tableta->placa = $_POST['placa'];
    $tableta->descripcion = $_POST['descripcion'];
    $tableta->tableta = $_POST['tableta'];

    if ($tableta->creartableta()) {
        echo "Tableta registrada exitosamente.";
        header("Location: ../vista/principal/admin.html");

    } else {
        echo "No se pudo registrar la tableta.";
    }
}
?>
