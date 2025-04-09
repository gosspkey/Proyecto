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
                <img src="../img/SENA-TECNO.png" alt="Logo" width="400px" style="position: relative; left: -20px;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="admin.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="centro de ayuda.html">Centro de ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    require_once '../../confi/conexion.php';
    require_once '../../modelo/administrador.php';

    $database = new Database();
    $conn = $database->getConnection();
    $adminObj = new Administrador($conn);

    // Verificar si hay un ID para editar
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Obtener los datos del administrador
        $stmt = $adminObj->listaradmin(); // Asegúrate de tener este método
        $adminData = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Idad'] == $id) {
                $adminData = $row;
                break;
            }
        }

        if (!$adminData) {
            echo "❌ Administrador no encontrado.";
            exit();
        }
    }

    // Si se envía el formulario, actualizar el administrador
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminObj->id = $_POST['id'];
        $adminObj->nombre = $_POST['nombre'];
        $adminObj->apellido = $_POST['apellido'];
        $adminObj->identi = $_POST['identi'];
        $adminObj->documento = $_POST['documento'];
        $adminObj->email = $_POST['correo'];
        $adminObj->usuario = $_POST['usuario'];
        $adminObj->contra = $_POST['contraseña']; // El método ya lo hashea
    
        $resultado = $adminObj->actualizar();
    
        if ($resultado) {
            header("Location: tablaadminis.php");
            exit;
        } else {
            echo "Error al actualizar.";
        }
    }
    ?>


<form method="POST" action="actualadadmin.php" method="POST" class="container">
    <input type="hidden" name="id" value="<?= $adminData['Idad'] ?>">
    <h2 class="titulo text-center"> <strong>Actualizar Administrador</strong></h2>
    <div class="row">
        <div class="container mt-5 col-md-6 form1 form-group">
            <label for="nombre" class="mr-2">Nombre(s):</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $adminData['Nombread'] ?>" required>

            <label for="apellido" class="mr-2">Apellidos:</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $adminData['Apellidoad'] ?>" required>

            <label for="usuario" class="mr-2">Nombre de usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $adminData['Usuario'] ?>" required>

            <label for="identificacion" class="mr-2">Tipo de documento:</label>
            <select class="form-control" id="identi" name="identi" value="<?= $adminData['Identificacionad'] ?>" required>
                <option value="C.C">C.C</option>
                <option value="C.E">C.E</option>
                <option value="P.P.T">P.P.T</option>
            </select>

        </div>

        <div class="container mt-5 col-md-6 form1 form-group">

            <label for="documento" class="mr-2">Numero de documento:</label>
            <input type="text" class="form-control" id="documento" name="documento" value="<?= $adminData['Documentoad'] ?>" required>

            <label for="correo" class="mr-2">Correo electronico:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?= $adminData['Emailad'] ?>" required>

            <label for="contraseña" class="mr-2">Contraseña:</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            <span class="vercontra" onclick="vercontra('contraseña', this)">👁️‍🗨️</span>
            <script>
                function vercontra(id, element) {
                    const passwordInput = document.getElementById(id);
                    const passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', passwordType);
                    // Cambiar el símbolo de la lectura de la contraseña
                    element.textContent = passwordType === 'password' ? '👁️‍🗨️' : '👀';
                }
            </script>
        </div>
    </div>
    <div class="text-center mt-4">
        <button class="btn btnn btn-successs customm-button btninicio" type="submit">Actualizar</button>
    </div>
    <br>
    <div class="row text-center mt-3 d-flex justify-content-center links-container">
        <div class="formtxt col-12 col-md-4 mb-2">
            <a href="#" class="links d-inline-block text-center">Términos y condiciones</a>
        </div>
    </div>
    
</form>
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
            .links {
    display: block;
    margin-top: 10px;
    color: #68aa26;
    text-decoration: none;
}
.links:hover {
    background-color: #ddebcf;
    color: #4b8413;
    border-radius: 20px;
    text-decoration: none;
}
            
        </style>
        <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
            <img class="footer-logo" src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
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
                    +573012845024
                </p>
            </div>
            <div class="iconos ema col-md-2">
                <p>
                    <strong>Correo:</strong>
                    <br>
                    soportecenigraf2025@gmail.com
                </p>
            </div>
            </div>
            <div class="iconos ema col-md-2">
    </div>
    </footer>
       

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
