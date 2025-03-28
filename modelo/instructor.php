<?php
class Instructores {
    private $conn;
    private $table = "Instructores";
    public $id;
    public $nombrein;
    public $apellidoin;
    public $identiin;
    public $documentoin;
    public $emailin;
    public $usuarioin;
    public $contrain;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    public function actualizarins() {
        $query = "UPDATE " . $this->table . " 
                  SET Nombrein = :nombrein, Apellidoin = :apellidoin, Identificacionin = :identiin, 
                      Documentoin = :documentoin, Emailin = :emailin, Usuarioin = :usuarioin, 
                      Contraseñain = :contrain 
                  WHERE IDinstructor = :id";
        
        $res = $this->conn->prepare($query);
    
        // Limpiar datos
        $this->nombrein = htmlspecialchars(strip_tags($this->nombrein));
        $this->apellidoin = htmlspecialchars(strip_tags($this->apellidoin));
        $this->identiin = htmlspecialchars(strip_tags($this->identiin));
        $this->documentoin = htmlspecialchars(strip_tags($this->documentoin));
        $this->emailin = htmlspecialchars(strip_tags($this->emailin));
        $this->usuarioin = htmlspecialchars(strip_tags($this->usuarioin));
        $this->contrain = password_hash($this->contrain, PASSWORD_BCRYPT);
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Vincular parámetros
        $res->bindParam(':nombrein', $this->nombrein);
        $res->bindParam(':apellidoin', $this->apellidoin);
        $res->bindParam(':identiin', $this->identiin);
        $res->bindParam(':documentoin', $this->documentoin);
        $res->bindParam(':emailin', $this->emailin);
        $res->bindParam(':usuarioin', $this->usuarioin);
        $res->bindParam(':contrain', $this->contrain);
        $res->bindParam(':id', $this->id);
    
        // Ejecutar la consulta
        if ($res->execute()) {
            echo "Instructor actualizado exitosamente.";
            return true;
        } else {
            // Manejo de errores
            $errorInfo = $res->errorInfo();
            echo "Error al actualizar el instructor: " . $errorInfo[2];
            return false;
        }
    }
    public function idisns() {
        $query = "SELECT * FROM " . $this->table . " WHERE IDinstructor = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
    
        // Limpiar datos
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Vincular el parámetro ID
        $stmt->bindParam(':id', $this->id);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Verificar si se encontró un registro
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un arreglo asociativo con los datos
            } else {
                echo "No se encontró el instructor con el ID proporcionado.";
                return false;
            }
        } else {
            // Manejo de errores
            $errorInfo = $stmt->errorInfo();
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    }
    

    public function registrarinstru() {
        echo "Intentando registrar instructor...<br>";
        if ($this->validarins()) {
            echo "Error: el usuario ya existe";
            return false;
        }
    
        $query = "INSERT INTO " . $this->table . " (Nombrein, Apellidoin, Identificacionin, Documentoin, Emailin, Usuarioin, Contraseñain) 
        VALUES (:nombrein, :apellidoin, :identiin, :documentoin, :emailin, :usuarioin, :contrain)";
    
        $res = $this->conn->prepare($query);
    
        $this->nombrein = htmlspecialchars(strip_tags($this->nombrein));
        $this->apellidoin = htmlspecialchars(strip_tags($this->apellidoin));
        $this->identiin = htmlspecialchars(strip_tags($this->identiin));
        $this->documentoin = htmlspecialchars(strip_tags($this->documentoin));
        $this->emailin = htmlspecialchars(strip_tags($this->emailin));
        $this->usuarioin = htmlspecialchars(strip_tags($this->usuarioin));
        $this->contrain = password_hash($this->contrain, PASSWORD_BCRYPT);
    
        // Vincular parámetros
        $res->bindParam(':nombrein', $this->nombrein);
        $res->bindParam(':apellidoin', $this->apellidoin);
        $res->bindParam(':identiin', $this->identiin);
        $res->bindParam(':documentoin', $this->documentoin);
        $res->bindParam(':emailin', $this->emailin);
        $res->bindParam(':usuarioin', $this->usuarioin);
        $res->bindParam(':contrain', $this->contrain);
    
        // Ejecutar la consulta
        if ($res->execute()) {
            echo "Instructor registrado exitosamente.";
            return true;
        } else {
            // Manejo de errores
            $errorInfo = $res->errorInfo();
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    }
    

    // Verificar si existe el email o el nombre de usuario
    public function validarins() {
        // Crear la consulta de búsqueda
        $query = "SELECT IDinstructor FROM " . $this->table . " WHERE Emailin=:emailin OR Usuarioin=:usuarioin LIMIT 1";
    
        // Resultado de la creación
        $consulta = $this->conn->prepare($query);
    
        // Encriptación
        $this->emailin = htmlspecialchars(strip_tags($this->emailin));
        $this->usuarioin = htmlspecialchars(strip_tags($this->usuarioin));
    
        // Resultado conexión
        $consulta->bindParam(':emailin', $this->emailin);
        $consulta->bindParam(':usuarioin', $this->usuarioin);
    
        $consulta->execute();
    
        return $consulta->rowCount() > 0;
    }

    // Función para listar los usuarios registrados
    public function listarins() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }
}
?>