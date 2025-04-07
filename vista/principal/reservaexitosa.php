
<?php
require_once('../../confi/conexion.php');

// Verificar si se recibió el ID de la reserva
if (!isset($_GET['id'])) {
    echo "No se proporcionó un ID de reserva.";
    exit;
}

$idReserva = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Reserva Exitosa</title>
    <script>
        // Contador regresivo
        let tiempo = 600; // Tiempo en segundos
        function iniciarContador() {
            const contador = document.getElementById('contador');
            const intervalo = setInterval(() => {
                if (tiempo <= 0) {
                    clearInterval(intervalo);
                    contador.innerHTML = "El tiempo ha terminado.";
                } else {
                    contador.innerHTML = `Tiempo restante: ${tiempo} segundos`;
                    tiempo--;
                }
            }, 1000);
        }
        window.onload = iniciarContador;
    </script>
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Reserva realizada</h1>
        <p>Tu reserva ha sido registrada correctamente, acercate a la area de audiovisuales para retirar tu equipo.</p>
        <p id="contador" class="text-danger font-weight-bold"></p>
        <form action="../../controlador/cancelarusuario.php" method="GET">
    <input type="hidden" name="id" value="<?php echo $idReserva; ?>">
    <button type="submit" class="btn btn-danger mt-3">Cancelar Reserva</button>
</form>
    </div>
</body>
</html>