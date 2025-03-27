<?php
require_once "../confi/conexion.php";
include_once '../modelo/usuario.php';
include_once '../modelo/instructor.php';

// Obtener la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Clase para manejar el inicio de sesión y registro
class UsuarioControlador {
    private $usu;
    private $ins;

    public function __construct($db) {
        $this->usu = new Usuario($db);
        $this->ins = new Instructores($db);
    }

    public function registrar($data) {
        $this->usu->nombre = $data['nombre'];
        $this->usu->apellido = $data['apellido'];
        $this->usu->identi = $data['identi'];
        $this->usu->documento = $data['documento'];
        $this->usu->telefono = $data['telefono'];
        $this->usu->email = $data['correo'];
        $this->usu->ficha = $data['ficha'];
        $this->usu->usuario = $data['usuario'];
        $this->usu->rol = $data["rol"];
        $this->usu->contra = $data['contraseña'];

        if ($this->usu->crearusu()) {
            echo "Usuario registrado exitosamente.";
            header("Location: ../vista/iniciosesion.html");
            exit();
        } else {
            echo "Error al registrar el usuario.";
        }
    }

    public function registrarinst($data) {
        $this->ins->nombrein = $data['nombrein'];
        $this->ins->apellidoin = $data['apellidoin'];
        $this->ins->identiin = $data['identiin'];
        $this->ins->documentoin = $data['documentoin'];
        $this->ins->emailin = $data['emailin'];
        $this->ins->usuarioin = $data['usuarioin'];
        $this->ins->contrain = $data['contraseñain'];

        if ($this->ins->registrarinstru()) {
            echo "Instructor registrado exitosamente.";
            header("Location: ../vista/principal/admin.html");
            exit();
        } else {
            echo "Error al registrar el instructor.";
        }
        
    }

public function validaringreso($usuario, $password) {
    $this->usu->usuario = $usuario;
    $this->usu->contra = $password;

    if ($this->usu->ingresar()) {
        // Iniciar sesión
        session_start();

        // Definir las variables de sesión
        $_SESSION['id'] = $this->usu->id;
        $_SESSION['usuario'] = $this->usu->usuario;
        $_SESSION['rol'] = $this->usu->rol;
        $_SESSION['correo'] = $this->usu->correo ?? null; // Asegúrate de que $this->usu->correo esté configurado

        // Verificar que las variables de sesión están establecidas
        echo "Variables de sesión configuradas:<br>";
        echo "ID del usuario: " . $_SESSION['id'] . "<br>";
        echo "Usuario: " . $_SESSION['usuario'] . "<br>";
        echo "Rol: " . $_SESSION['rol'] . "<br>";
        echo "Correo: " . $_SESSION['correo'] . "<br>";

        // Redirigir según el rol
        ob_start(); // Inicia el buffer de salida
        if ($_SESSION['rol'] === 'Administrador') {
            header("Location: ../vista/principal/admin.html");
            ob_end_flush(); // Enviar el buffer de salida
            exit;
        } elseif ($_SESSION['rol'] === 'Estudiante') {
            header("Location: ../vista/principal/equipos.html");
            ob_end_flush(); // Enviar el buffer de salida
            exit;
        }
    } else {
        echo "Error: Credenciales incorrectas";
    }
    return false;
}
}

// Manejar la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controlador = new UsuarioControlador($db);
    if (isset($_POST["usuario"]) && isset($_POST["contraseña"]) && !isset($_POST["nombre"]) && !isset($_POST["apellido"]) && !isset($_POST["correo"])) {
        $controlador->validaringreso($_POST["usuario"], $_POST["contraseña"]);
    } elseif (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["correo"]) && isset($_POST["ficha"])) {
        $controlador->registrar($_POST);
    } elseif (isset($_POST["nombrein"]) && isset($_POST["apellidoin"]) && isset($_POST["emailin"]) && isset($_POST["contrain"])) {
        echo "Datos recibidos para registrar instructor: ";
        print_r($_POST); // Mensaje de depuración
        $controlador->registrarinst($_POST);
    }
    

}
?>