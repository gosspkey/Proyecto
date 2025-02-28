<!DOCTYPE html>
<html lang="en">
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
                <img src="../img/logo-blanco.png" alt="Logo" width="300px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tablainstu.php">Tabla Instructores</a>
                    </li>
                </ul>
            </div>
        </div>
        </nav>

<?php
require_once('../../modelo/usuario.php');
require_once('../../confi/conexion.php');
$database = new Database();
$db = $database->getConnection();
$usuario= new Usuario($db);
$usu = $usuario->listarusu();

if (!$usu || $usu->rowCount()==0){
    echo "No hay usuarios registrados";
}else
{


        echo "<h1>Estudiantes</h1>";
        echo "<link rel='stylesheet' href='../css/style.css'>";
        echo "<table class = 'custom-table'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tipo de identificacion</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Ficha</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Contraseña</th>

                </tr>
            </thead>";

             while($f = $usu->fetch(PDO::FETCH_ASSOC)){

               echo "<tr>
                    <td>".$f["IDUsuario"]. "</td>
                    <td>".$f["Nombre"]. "</td>
                    <td>".$f["Apellido"]. "</td>
                    <td>".$f["Identificacion"]. "</td>
                    <td>".$f["Documento"]. "</td>
                    <td>".$f["Telefono"]. "</td>
                    <td>".$f["Email"]. "</td>
                    <td>".$f["Ficha"]. "</td>
                    <td>".$f["Usuario"]. "</td>
                    <td>".$f["Rol"]. "</td>
                    <td>".$f["Contraseña"]. "</td>
                    <td>

                    <a href='actualizar.php?id=" . $f["IDUsuario"] . "' class='custom-button'>Actualizar</a>
                    <a href='borrar.php?id=" . $f["IDUsuario"] . "' class='custom-button'>Borrar</a>

         

                    </td>


            </tr>";

             }

            echo "</table>";
}
        
?>

<footer class="mt-5 border-top">
        <div class="container text-center py-4 col-md-2">
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
        <div class="text-center py-3 col-md-2">
            <img src="../img/logo naranja.png" alt="Logo">
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

