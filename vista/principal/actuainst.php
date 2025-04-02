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
    <!--<nav class="navbar navbar-expand-lg navbar-light">
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
                        <a style="position: relative; left: 170px;" class="nav-link" href="../vista/iniciosesion.html">Inicio sesion</a>
                    </li>
                    <li class="nav-item">
                        <a style="position: relative; left: 170px; " class="nav-link" href="#">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
        <img src="../img/sena logo blamco.png" alt="Logo" width="120px" class="d-inline-block align-top" style="position: relative; left: -100px;">
    </nav>
-->
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/SENA-TECNO.png  " alt="Logo" width="300px" style="position: relative; left: -20px;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/admin.html">inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3"href="../principal/centro de ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
           
        </div>
    </nav>
<?php
    require_once('../../modelo/instructor.php');
    require_once('../../confi/conexion.php');
    $database = new Database();
    $db = $database->getConnection();
    $instructor = new Instructores($db);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $instructor->id = $id;
        $data = $instructor->idisns();
        if ($data) {
            $fila = $data;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $instructor->id = $_POST['IDInstructor'];
        $instructor->nombrein = $_POST['nombre'];
        $instructor->apellidoin = $_POST['apellido'];
        $instructor->identiin = $_POST['identi'];
        $instructor->documentoin = $_POST['documento'];
        $instructor->emailin = $_POST['correo'];
        $instructor->usuarioin = $_POST['usuario'];
        
        // Solo encriptamos la contraseña si ha sido cambiada
        if (!empty($_POST['contraseña'])) {
            $instructor->contrain = $_POST['contraseña'];
        } else {
            // Mantenemos la contraseña existente si no se ha cambiado
            $instructor->contrain = $fila['Contraseñain'];
        }

        if ($instructor->actualizarins()) {
            echo "Instructor actualizado correctamente.";
        } else {
            echo "Error al actualizar el instructor.";
        }
    }
    ?>

    <form action="actuainst.php?id=<?php echo $instructor->id; ?>" method="POST" class="container">
        <input type="hidden" name="IDInstructor" value="<?php echo $fila['IDinstructor']; ?>">
        <h2 class="titulo text-center"> <strong>Actualizar Instructor</strong></h2>
        <div class="row">
            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="nombre" class="mr-2">Nombre(s):</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" value="<?php echo $fila['Nombrein']; ?>" required>

                <label for="apellido" class="mr-2">Apellidos:</label>
                <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Ingrese sus apellidos" value="<?php echo $fila['Apellidoin']; ?>" required>

                <label for="identi" class="mr-2">Tipo de documento:</label>
                <select name="identi" id="identi" class="form-control">
                    <option value="C.C" <?php echo ($fila['Identificacionin'] == 'C.C') ? 'selected' : ''; ?>>C.C</option>
                    <option value="T.I" <?php echo ($fila['Identificacionin'] == 'T.I') ? 'selected' : ''; ?>>T.I</option>
                    <option value="C.E" <?php echo ($fila['Identificacionin'] == 'C.E') ? 'selected' : ''; ?>>C.E</option>
                    <option value="P.P.T" <?php echo ($fila['Identificacionin'] == 'P.P.T') ? 'selected' : ''; ?>>P.P.T</option>
                </select>

                <label for="documento" class="mr-2">Número de documento:</label>
                <input type="text" class="form-control" name="documento" id="documento" placeholder="Ingrese su número del documento" value="<?php echo $fila['Documentoin']; ?>" required>

                <label for="correo" class="mr-2">Correo electrónico:</label>
                <input type="email" class="form-control" name="correo" id="correo" placeholder="Ingrese correo" value="<?php echo $fila['Emailin']; ?>" required>
            </div>

            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="usuario" class="mr-2">Nombre de usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Ingrese un usuario" value="<?php echo $fila['Usuarioin']; ?>" required>

                <label for="contraseña" class="mr-2">Contraseña:</label>
                <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Ingrese su contraseña">
                <span class="vercontra" onclick="vercontra('contraseña', this)">👁️‍🗨️</span>
                <script>
                    function vercontra(id, element) {
                        const passwordInput = document.getElementById(id);
                        const passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', passwordType);
                        element.textContent = passwordType === 'password' ? '👁️‍🗨️' : '👀';
                    }
                </script>
            </div>
        </div>
        <div class="btn btnn btn-successs customm-button btninicio" type="submit" style="width: 50%;">Guardar cambios</button>
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