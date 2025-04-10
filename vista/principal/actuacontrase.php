<?php
session_start();
if (!isset($_SESSION['Idusu'])) {
    echo "No has iniciado sesión. Por favor, ingresa.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contraactual = $_POST['contraactual'];
    $contranueva = $_POST['contranueva'];
    $confirmarcontra = $_POST['confirmarcontra'];

    if ($contranueva !== $confirmarcontra) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Conexión a la base de datos
    $host = "localhost";
    $dbname = "proyecto";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar la contraseña actual
        $stmt = $conn->prepare("SELECT Contraseña FROM Usuario WHERE Idusu = :id");
        $stmt->bindParam(':id', $_SESSION['Idusu'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($contraactual, $user['Contraseña'])) {
            echo "La contraseña actual es incorrecta.";
            exit;
        }

        // Actualizar la contraseña
        $hashed_password = password_hash($contranueva, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE Usuario SET Contraseña = :contranueva WHERE Idusu = :id");
        $update_stmt->bindParam(':contranueva', $hashed_password, PDO::PARAM_STR);
        $update_stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            echo "Contraseña actualizada correctamente.";
            header("Location: perfil.php");
        } else {
            echo "Error al actualizar la contraseña.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="../css/style.css"> 
    <title>Cambiar Contraseña</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../vista/img/SENA-TECNO.png  " alt="Logo" width="400px" style="position: relative; left: -20px;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                
            </div>
        </div>
    </nav>
    <form action="actuacontrase.php" method="POST" class="container">
    <h2 class="titulo text-center mb-4"> <strong>Cambiar Contraseña</strong></h2>
        <div class="row">
            
            <div class="container mt-5 col-md-6 form1 form-group">
                    <label for="usuario" class="mb-2">Contraseña Actual:</label>
                    <input type="password" class="form-control" id="contraactual" name="contraactual" required>
    
                    <label for="contraseña" class="mb-2 mt-3">Contraseña nueva:</label>
                    <input type="password" class="form-control" id="contranueva" name="contranueva" required>

                    <label for="contraseña" class="mb-2 mt-3">Confirma contraseña nueva:</label>
                    <input type="password" class="form-control" id="confirmarcontra" name="confirmarcontra" required>

                    <div class="text-center mt-4">
                        <button  class="btn btnn btn-successs customm-button btninicio" type="submit" style="width: 50%;">Cambiar contraseña</button>
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
            <img class="footer-logo" src="../../vista/img/LOGO SENA-TECCNO.png" alt="Logo" width="700px">
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
        <script src="../Proyecto/vista/js/atras.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>