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
                        <a style="position: relative; left: 170px; " class="nav-link" href="#">Ayuda</a>
                    </li>
                </ul>
            </div>
           
        </div>
        <img src="../img/sena logo blamco.png" alt="Logo" width="120px" class="d-inline-block align-top" style="position: relative; left: -100px;">
    </nav>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('../../modelo/instructor.php');
    $db = new Database(); // Aquí se crea la conexión a la base de datos
    $instructor = new Instructores($db);

    // Capturar datos del formulario
    $instructor->id = $_POST['id']; // Aquí debes asegurarte de tener el ID en el formulario
    $instructor->nombrein = $_POST['nombrein'];
    $instructor->apellidoin = $_POST['apellidoin'];
    $instructor->identiin = $_POST['identiin'];
    $instructor->documentoin = $_POST['documentoin'];
    $instructor->emailin = $_POST['emailin'];
    $instructor->usuarioin = $_POST['usuarioin'];
    $instructor->contrain = $_POST['contrain'];

    // Verificar si es para actualizar o registrar
    if (isset($_POST['actualizar'])) {
        $instructor->actualizarins();
    } else {
        $instructor->registrarinstru();
    }
}
?>

    <form action="../../controlador/usuariocont.php" method="POST" class="container">
    <input type="hidden" name="id" id="id" value="<?php echo $fila['IDinstructor']; ?>">
    <h2 class="titulo text-center"> <strong>Registro Instructor</strong></h2>
        <div class="row">
            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="nombre" class="mr-2">Nombre(s):</label>
                <input type="text" class="form-control" id="nombrein" name="nombrein" placeholder="Ingrese su nombre" required>

                <label for="apellido" class="mr-2">Apellidos:</label>
                <input type="text" class="form-control" name="apellidoin" id="apellidoin" placeholder="Ingrese sus apellidos" required>

                <label for="identi" class="mr-2">Tipo de documento:</label>
                <select name="identiin" id="identiin" class="form-control">
                    <option value="C.C">C.C</option>
                    <option value="T.I">T.I</option>
                    <option value="C.E">C.E</option>
                    <option value="P.P.T">P.P.T</option>
                </select>

                <label for="documento" class="mr-2">Numero de documento:</label>
                <input type="text" class="form-control" name="documentoin" id="documentoin" placeholder="Ingrese su numero del documento" required>

               
                
                <label for="correo" class="mr-2">Correo electronico:</label>
                <input type="email" class="form-control" name="emailin" id="emailin" placeholder="Ingrese correo" required>
            </div>

            <div class="container mt-5 col-md-6 form1 form-group">

                <label for="usuario" class="mr-2">Nombre de usuario:</label>
                <input type="text" class="form-control" name="usuarioin" id="usuarioin" placeholder="Ingrese un usuario" required>

                <label for="contraseña" class="mr-2">Contraseña:</label>
                <input type="password" class="form-control" name="contrain" id="contrain" placeholder="Ingrese su contraseña" required>
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
        <button class="btn btn-warning custom-button" type="submit" name="actualizar">Actualizar</button>
        </div>
        <br><br>
        <div class="container">
            <div class="row">
                <div class="formtxt col-md-4">
                    <a href="../vista/principal/olvidocontraseña.html">¿Olvidaste tu contraseña?</a>
                </div>
                <div class="formtxt">
                    <a href="../vista/iniciosesion.html">¿Ya tienes una cuenta? <br> <strong>Iniciar sesion</strong></a>
                </div>
                <div class="formtxt col-md-4">
                    <a href="#">Terminos y condiciones</a>
                </div>
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
    <script src="estilos.js"></script>
</body>
</html>
<?php
// Consultar los datos del instructor a editar
require_once('../../modelo/instructor.php');
$db = new Database();
$instructor = new Instructores($db);

if (isset($_GET['id'])) {
    $instructor->id = $_GET['id'];
    $datos = $instructor->idisns(); // Función para consultar instructor por ID
    if ($datos) {
        $nombrein = $datos['Nombrein'];
        $apellidoin = $datos['Apellidoin'];
        $identiin = $datos['Identificacionin'];
        $documentoin = $datos['Documentoin'];
        $emailin = $datos['Emailin'];
        $usuarioin = $datos['Usuarioin'];
    }
}
?>
<input type="text" class="form-control" id="nombrein" name="nombrein" value="<?php echo $nombrein; ?>" required>
