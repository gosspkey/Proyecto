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
    require_once('../../modelo/usuario.php');
    require_once('../../confi/conexion.php');
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $usuario->id = $id;
        $data = $usuario->Usuuno();
        $fila = $data->fetch(PDO::FETCH_ASSOC);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario->id = $_POST['IDUsuario'];
        $usuario->nombre = $_POST['nombre'];
        $usuario->apellido = $_POST['apellido'];
        $usuario->identi = $_POST['identi'];
        $usuario->documento = $_POST['documento'];
        $usuario->telefono = $_POST['telefono'];
        $usuario->email = $_POST['correo'];
        $usuario->ficha = $_POST['ficha'];
        $usuario->usuario = $_POST['usuario'];
        $usuario->rol = $_POST['rol'];
        $usuario->contra = $_POST['contraseña'];

        if ($usuario->actualizar()) {
            echo "Usuario actualizado correctamente.";
        } else {
            echo "Error al actualizar el usuario.";
        }
    }
    ?>

    <form action="actuadmin.php?id=<?php echo $usuario->id; ?>" method="POST" class="container">
        <input type="hidden" name="IDUsuario" value="<?php echo $fila['IDUsuario']; ?>">
        <h2 class="titulo text-center"> <strong>Actualizar Usuario</strong></h2>
        <div class="row">
            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="nombre" class="mr-2">Nombre(s):</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>

                <label for="apellido" class="mr-2">Apellidos:</label>
                <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Ingrese sus apellidos" required>

                <label for="identi" class="mr-2">Tipo de documento:</label>
                <select name="identi" id="identi" class="form-control">
                    <option value="C.C">C.C</option>
                    <option value="T.I">T.I</option>
                    <option value="C.E">C.E</option>
                    <option value="P.P.T">P.P.T</option>
                </select>

                <label for="documento" class="mr-2">Numero de documento:</label>
                <input type="text" class="form-control" name="documento" id="documento" placeholder="Ingrese su numero del documento" required>

                <label for="telefono" class="mr-2">Telefono:</label>
                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Ingrese numero de contacto" required>
                
                <label for="correo" class="mr-2">Correo electronico:</label>
                <input type="email" class="form-control" name="correo" id="correo" placeholder="Ingrese correo" required>
            </div>

            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="ficha" class="mr-2">Ficha:</label>
                <input type="text" class="form-control" name="ficha" id="ficha" placeholder="Ingrese una ficha" required>

                <label for="usuario" class="mr-2">Nombre de usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingrese un usuario" required>

                <label for="rol" class="mr-2">Rol:</label>
                <select name="rol" id="rol" class="form-control">
                    <option value="Administrador">Administrador</option>
                    <option value="Estudiante">Estudiante</option>
                </select>

                <label for="contraseña" class="mr-2">Contraseña:</label>
                <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Ingrese su contraseña" required>
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
            <button class="btn btn-success custom-button" type="submit">Guardar cambios</button>
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
            <div class="iconos ema col-md-2">
    </div>
    </footer>
       

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php
require_once('../../modelo/usuario.php');
require_once('../../confi/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Usuario($db);

    $usuario->id = $_POST['IDUsuario'];
    $usuario->nombre = $_POST['nombre'];
    $usuario->apellido = $_POST['apellido'];
    $usuario->identi = $_POST['identi'];
    $usuario->documento = $_POST['documento'];
    $usuario->telefono = $_POST['telefono'];
    $usuario->email = $_POST['correo'];
    $usuario->ficha = $_POST['ficha'];
    $usuario->usuario = $_POST['usuario'];
    $usuario->rol = $_POST['rol'];
    
    // Solo encriptamos la contraseña si ha sido cambiada
    if (!empty($_POST['contraseña'])) {
        $usuario->contra = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    } else {
        // Mantenemos la contraseña existente si no se ha cambiado
        $data = $usuario->Usuuno();
        $fila = $data->fetch(PDO::FETCH_ASSOC);
        $usuario->contra = $fila['Contraseña'];
    }

    if ($usuario->actualizar()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>
