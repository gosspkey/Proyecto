<?php
require_once('../../confi/conexion.php');

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Consultar las tabletas disponibles
$query = "SELECT CodEquipo, Tableta FROM Tabletas";
$stmt = $db->prepare($query);
$stmt->execute();

$tabletas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"> 
    <title>TECNO-SENA</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/logo-blanco.png" alt="Logo" width="300px" style="position: relative; left: -20px;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a style="position: relative; left: 170px;" class="nav-link" href="#">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
        <img src="../img/sena logo blamco.png" alt="Logo" width="120px" class="d-inline-block align-top" style="position: relative; left: -100px;">
    </nav>

    <form action="../controlador/reservascont.php" method="POST" class="container">
        <h2 class="titulo text-center"><strong>Reserva de Tablet</strong></h2>
        <div class="row">
            <div class="col-md-6">
                <img src="../img/tablet651.png" class="img-fluid" alt="Tablet Image" width="300px">
            </div>
            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="ficha" class="mr-2">Número de Ficha:</label>
                <input type="text" class="form-control" name="ficha" id="ficha" placeholder="Ingrese el número de ficha" required>

                <label for="CodEquipo" class="mr-2">¿Qué tablet deseas reservar?</label>
                <select name="CodEquipo" id="CodEquipo" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($tabletas as $tableta): ?>
                        <option value="<?php echo $tableta['CodEquipo']; ?>">
                            <?php echo $tableta['Tableta']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>    
        </div>
        <div class="d-flex justify-content-center button-center">
            <div class="button">
                <button class="btn custom-button" type="submit" onclick="return showAlert()">Reservar</button>
            </div>
            <div class="button">
                <a href="../principal/equipos.html">
                    <button class="btn custom-button" type="button">Cancelar</button>
                </a>
            </div>
        </div>
        <br>
    </form>
</body>

<footer class="mt-5 border-top">
    <style>
        footer {
            background-color: #5EA617;
            color: white;
        }
        footer a {
            color: white;
        }
        footer p, footer h2, footer strong {
            color: white !important;
        }
    </style>
    <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
        <img class="footer-logo" src="../img/tecno sena logo blanco.PNG" alt="Logo">
        <h2>Tecno-Sena</h2>
        <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
    </div>
    <div class="container d-flex justify-content-around py-3">
        <div class="iconos dire col-md-2">
            <p>
                <strong>Dirección:</strong>  
                <br> 
                #31-42 Calle 15, Bogotá
            </p>
        </div>
        <div class="iconos tel col-md-2">
            <p> 
                <strong>Telefono:</strong> 
                <br> 
                +573222175535
            </p>
        </div>
        <div class="iconos ema col-md-2">
            <p>
                <strong>Correo:</strong>
                <br>
                equipoceni@soy.sena.edu.co
            </p>
        </div>
    </div>
    <img src="../img/sena logo blamco.png" alt="Logo" width="300px" style="position: relative; left: -100px;" class="d-inline-block align-top">
</footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>

</html>
