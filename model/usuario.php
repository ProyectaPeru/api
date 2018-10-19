<?php
class Usuario{
    private $conn;
    private $table_name = "usuario";

    //object properties
    public $id;
    public $username;
    public $password;
    public $estado;
    public $valor_estado;
    public $fecha_creacion;
    public $id_perfil;
    public $nombre_perfil;

    //constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //getAll Users
    function getAll(){
        //select all query
        $query = "SELECT u.id, u.username, u.password, u.estado, (CASE u.estado WHEN '1' THEN 'ACTIVO' WHEN '0' THEN 'INACTIVO' END)
                    AS valor_estado, u.fecha_creacion, p.id AS id_perfil, p.nombre AS nombre_perfil FROM ". $this->table_name ." u
                    INNER JOIN perfil p ON u.id_perfil = p.id ORDER BY u.fecha_creacion DESC";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //create user
    function insert(){
        //query to insert user
        $query = "INSERT INTO ".$this->table_name." SET username=:username, password=:password, estado=:estado,
                    fecha_creacion=:fecha_creacion, id_perfil=:id_perfil";
        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));
        $this->id_perfil = htmlspecialchars(strip_tags($this->id_perfil));

        //bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);
        $stmt->bindParam(":id_perfil", $this->id_perfil);

        //execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>