<?php
class Usuario {
    private $conn;
    private $table = "Usuario";
    public $id;
    public $nombre;
    public $apellido;
    public $identi;
    public $documento;
    public $telefono;
    public $email;
    public $ficha;
    public $usuario;
    public $rol;
    public $contra;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear la función que permite ingresar usuario
    public function crearusu() {
        if ($this->validareu()) {
            echo "Error: el usuario ya existe";
            return false;
        }

        // Crear la sentencia SQL
        $query = "INSERT INTO " . $this->table . " (Nombre, Apellido, Identificacion, Documento, Telefono, Email, Ficha, Usuario, Rol, Contraseña) 
        VALUES (:nombre, :apellido, :identi, :documento, :telefono, :email, :ficha, :usuario, :rol, :contra)";
        $res = $this->conn->prepare($query);

        // Encriptar los datos
        $this->nombre = isset($this->nombre) ? htmlspecialchars(strip_tags($this->nombre)) : '';
        $this->apellido = isset($this->apellido) ? htmlspecialchars(strip_tags($this->apellido)) : '';
        $this->identi = isset($this->identi) ? htmlspecialchars(strip_tags($this->identi)) : '';
        $this->documento = isset($this->documento) ? htmlspecialchars(strip_tags($this->documento)) : '';
        $this->telefono = isset($this->telefono) ? htmlspecialchars(strip_tags($this->telefono)) : '';
        $this->email = isset($this->email) ? htmlspecialchars(strip_tags($this->email)) : '';
        $this->ficha = isset($this->ficha) ? htmlspecialchars(strip_tags($this->ficha)) : '';
        $this->usuario = isset($this->usuario) ? htmlspecialchars(strip_tags($this->usuario)) : '';
        $this->rol = isset($this->rol) ? htmlspecialchars(strip_tags($this->rol)) : '';
        $this->contra = isset($this->contra) ? password_hash($this->contra, PASSWORD_BCRYPT) : '';

        // Vincular parámetros
        $res->bindParam(':nombre', $this->nombre);
        $res->bindParam(':apellido', $this->apellido);
        $res->bindParam(':identi', $this->identi);
        $res->bindParam(':documento', $this->documento);
        $res->bindParam(':telefono', $this->telefono);
        $res->bindParam(':email', $this->email);
        $res->bindParam(':ficha', $this->ficha);
        $res->bindParam(':usuario', $this->usuario);
        $res->bindParam(':rol', $this->rol);
        $res->bindParam(':contra', $this->contra);

        // Ejecutar la consulta
        if ($res->execute()) {
            return true;
        } else {
            // Manejo de errores
            $errorInfo = $res->errorInfo();
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    }

    // Verificar si existe el email o el nombre de usuario
    public function validareu() {
        // Crear la consulta de búsqueda
        $query = "SELECT IDUsuario FROM " . $this->table . " WHERE Email=:email OR Usuario=:usuario LIMIT 1";

        // Resultado de la creación
        $consulta = $this->conn->prepare($query);

        // Encriptación
        $this->email = isset($this->email) ? htmlspecialchars(strip_tags($this->email)) : '';
        $this->usuario = isset($this->usuario) ? htmlspecialchars(strip_tags($this->usuario)) : '';

        // Resultado conexión
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':usuario', $this->usuario);

        $consulta->execute();

        return $consulta->rowCount() > 0;
    }

    // Función para listar los usuarios registrados
    public function listarusu() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    // Función para ingresar (iniciar sesión)
    public function ingresar() {
        // Crear la consulta SQL para obtener el usuario por nombre de usuario
        $query = "SELECT IDUsuario, Usuario, Rol, Contraseña FROM " . $this->table . " WHERE Usuario = :usuario LIMIT 1";
        $resul = $this->conn->prepare($query);

        // Limpiar los datos del usuario
        $this->usuario = isset($this->usuario) ? htmlspecialchars(strip_tags($this->usuario)) : '';

        // Vincular el parámetro usuario
        $resul->bindParam(":usuario", $this->usuario, PDO::PARAM_STR);

        // Ejecutar la consulta
        $resul->execute();

        // Verificar si se encontró un usuario
        if ($resul->rowCount() > 0) {
            $fil = $resul->fetch(PDO::FETCH_ASSOC);

            // Verificar si la contraseña es correcta
            if (password_verify($this->contra, $fil['Contraseña'])) {
                // Asignar los datos del usuario a las propiedades de la clase
                $this->id = $fil['IDUsuario'];
                $this->usuario = $fil['Usuario'];
                $this->rol = $fil['Rol'];
                $this->contra = $fil['Contraseña'];

                return true; // Ingreso exitoso
            } else {
                echo "Error: Contraseña incorrecta";
            }
        } else {
            echo "Error: Usuario no encontrado";
        }

        return false; 
    }
}
?>