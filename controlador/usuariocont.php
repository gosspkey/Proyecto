<?php
require_once "../confi/conexion.php";
include_once '../modelo/usuario.php';

// Obtener la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Clase para manejar el inicio de sesión y registro
class UsuarioControlador {
    private $usu;

    public function __construct($db) {
        $this->usu = new Usuario($db);
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

            // Verificar que las variables de sesión están establecidas
            echo "ID del usuario en sesión: " . $_SESSION['id'] . "<br>";
            echo "usuario: " . $_SESSION['usuario'] . "<br>";
            echo "correo: " . $_SESSION['correo'] . "<br>";

            // Redirigir según el rol
            ob_start(); // Inicia el buffer de salida
            if ($_SESSION['rol'] === 'Administrador') {
                header("Location:../vista/principal/admin.php");
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
    } elseif (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["correo"])) {
        $controlador->registrar($_POST);
    }
}
?>