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
                <img src="../img/logo-blanco.png" alt="Logo" width="300px" style="position: relative; left: -20px;"class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a style="position: relative; left: 170px; " class="nav-link" href="#">Ayuda</a>
                    </li>
                </ul>
            </div>
           
        </div>
        <img src="../img/sena logo blamco.png" alt="Logo" width="120px" class="d-inline-block align-top" style="position: relative; left: -100px;">
    </nav>

<?php
require_once('../../modelo/reservas.php');
require_once('../../confi/conexion.php');
$database = new Database();
$db = $database->getConnection();
$Reservas= new Reservas($db);
$Reservas = $Reservas->listaresv();

if (!$Reservas || $Reservas->rowCount()==0){
    echo "No hay usuarios registrados";
}else
{


        echo "<h1>Reservas</h1>";
        echo "<link rel='stylesheet' href='../css/style.css'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover table-striped custom-table'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>IDUsuario</th>
                    <th>CodEquipo</th>
                    <th>fichausu</th>
                    <th>FechaReserva</th>
                    <th>Acciones</th>

                </tr>
            </thead>";
        echo "<tbody>";
             while($f = $Reservas->fetch(PDO::FETCH_ASSOC)){

               echo "<tr>
                    <td data-label='ID'>".$f["IDReserva"]. "</td>
                    <td data-label='IDUsuario'>".$f["IDUsuario"]. "</td>
                    <td data-label='CodEquipo'>".$f["CodEquipo"]. "</td>
                    <td data-label='fichausu'>".$f["Fichausu"]. "</td>
                    <td data-label='FechaReserva'>".$f["FechaReserva"]. "
                    
                    <td>
            <a href='../../controlador/cancelarreser.php?id=".$f["IDReserva"]."' class='custom-button'>Cancelar</a>
            <a href='../../controlador/eliminarequipo.php?codigo=".$f["CodEquipo"]."' class='custom-button'>Eliminar Equipo</a>
        </td>


            </tr>";

             }
        echo "</tbody>";
            echo "</table>";
}
        
?>

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
</body>
</html>

