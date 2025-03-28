<?php
class Reservas {
    private $conn;
    private $table = "Reservas";
    public $IDReserva;
    public $IDUsuario;
    public $CodEquipo;
    public $fichausu;
    public $FechaReserva;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crearReserva() {
        $query = "INSERT INTO " . $this->table . " (IDUsuario, CodEquipo, Fichausu, FechaReserva)
                  VALUES (:IDUsuario, :CodEquipo, :fichausu, :FechaReserva)";
        $stmt = $this->conn->prepare($query);
    
        $this->IDUsuario = htmlspecialchars(strip_tags($this->IDUsuario));
        $this->CodEquipo = htmlspecialchars(strip_tags($this->CodEquipo));
        $this->fichausu = htmlspecialchars(strip_tags($this->fichausu));
        $this->FechaReserva = htmlspecialchars(strip_tags($this->FechaReserva));
    
        // Vincular los parámetros correctamente
        $stmt->bindParam(':IDUsuario', $this->IDUsuario);
        $stmt->bindParam(':CodEquipo', $this->CodEquipo);
        $stmt->bindParam(':fichausu', $this->fichausu);
        $stmt->bindParam(':FechaReserva', $this->FechaReserva);
    
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error al crear la reserva: " . $errorInfo[2];
            return false;
        }
    }

    // Función para listar los usuarios registrados
    public function listaresv() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    public function eliminarEquipo() {
        $query = "DELETE FROM Tabletas WHERE CodEquipo = :CodEquipo";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':CodEquipo', $this->CodEquipo);
    
        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error al eliminar el equipo: " . $errorInfo[2];
            return false;
        }
    }
    
    
    
}
?>
