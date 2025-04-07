<?php
class Tabletas {
    private $conn;
    private $table = "Tabletas";
    public $id;
    public $placa;
    public $descripcion;
    public $tableta;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar si la tableta ya existe
    private function validartbl() {
        $query = "SELECT * FROM " . $this->table . " WHERE Placa = :placa";
        $consulta = $this->conn->prepare($query);
        $consulta->bindParam(':placa', $this->placa);
        $consulta->execute();
    
        echo "Validando existencia: ";
        echo "Número de filas encontradas: " . $consulta->rowCount();
    
        return $consulta->rowCount() > 0;
    }
    
    

    public function creartableta() {
        // Imprimir datos recibidos
        echo "Datos recibidos:";
        var_dump($this->placa, $this->descripcion, $this->tableta);
    
        // Verificar si ya existe
        if ($this->validartbl()) {
            echo "Error: La tableta con la placa {$this->placa} ya existe.";
            return false;
        }
    
        // Preparar la consulta SQL
        $query = "INSERT INTO " . $this->table . " (Placa, Descripcion, Tableta) 
                  VALUES (:placa, :descripcion, :tableta)";
        $res = $this->conn->prepare($query);
    
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->tableta = htmlspecialchars(strip_tags($this->tableta));
    
        // Vincular parámetros
        $res->bindParam(':placa', $this->placa);
        $res->bindParam(':descripcion', $this->descripcion);
        $res->bindParam(':tableta', $this->tableta);
    
        // Imprimir consulta y parámetros
        echo "Consulta preparada: $query";
        echo "Parámetros vinculados: ";
        var_dump($this->placa, $this->descripcion, $this->tableta);
    
        // Ejecutar la consulta y manejar errores
        if ($res->execute()) {
            echo "Tableta registrada exitosamente.";
            return true;
        } else {
            $errorInfo = $res->errorInfo();
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    }
    
    

    // Función para listar los usuarios registrados
    public function listartbl() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    public function eliminarEquipo($codigoEquipo) {
        $query = "DELETE FROM Tabletas WHERE CodEquipo = :codigoEquipo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigoEquipo', $codigoEquipo, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    
    
}
?>