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

    //used when filling up the update product form
    function getById(){
        //query to read single user
        $query = "SELECT u.id, u.username, u.password, u.estado, (CASE u.estado WHEN '1' THEN 'ACTIVO' WHEN '0' THEN 'INACTIVO' END)
        AS valor_estado, u.fecha_creacion, p.id AS id_perfil, p.nombre AS nombre_perfil FROM ". $this->table_name ." u
        INNER JOIN perfil p ON u.id_perfil = p.id ORDER AND u.id = ? LIMIT 0,1";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind id of user to be updated
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();

        //get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to object properties
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->estado = $row['estado'];
        $this->valor_estado = $row['valor_estado'];
        $this->fecha_creacion = $row['fecha_creacion'];
        $this->id_perfil = $row['id_perfil'];
        $this->nombre_perfil = $row['nombre_perfil'];
    }

    function update(){
        //update query
        $query = "UPDATE ".$this->table_name." SET username=:username, password=:password, estado=:estado, id_perfil=:id_perfil WHERE id=:id";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->id_perfil = htmlspecialchars(strip_tags($this->id_perfil));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":id_perfil", $this->id_perfil);
        $stmt->bindParam(":id", $this->id);

        //execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //delete the user
    function delete(){
        //delete query
        $query = "DELETE FROM ".$this->table_name." WHERE id=?";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind id of user to delete
        $stmt->bindParam(1, $this->id);

        //execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //login
    function login(){
        //query to read single user
        $query = "SELECT u.id, u.username, u.fecha_creacion, u.estado, p.id AS id_perfil, p.nombre AS nombre_perfil FROM ". $this->table_name ." u
        INNER JOIN perfil p ON u.id_perfil = p.id ORDER AND u.username = ? AND u.password = ? LIMIT 0,1";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind id of user to be updated
        $stmt->bindParam(1, $this->username);
        $stmt->bindParam(2, $this->password);

        //execute query
        $stmt->execute();

        //get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to object properties
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->estado = $row['estado'];
        $this->fecha_creacion = $row['fecha_creacion'];
        $this->id_perfil = $row['id_perfil'];
        $this->nombre_perfil = $row['nombre_perfil'];
    }

    //search Users
    function search($keywords){
        //select all query
        $query = "SELECT u.id, u.username, u.password, u.estado, (CASE u.estado WHEN '1' THEN 'ACTIVO' WHEN '0' THEN 'INACTIVO' END)
                    AS valor_estado, u.fecha_creacion, p.id AS id_perfil, p.nombre AS nombre_perfil FROM ". $this->table_name ." u
                    INNER JOIN perfil p ON u.id_perfil = p.id AND u.username LIKE ? ORDER BY u.fecha_creacion DESC";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        //bind
        $stmt->bindParam(1, $keywords);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //read users whit pagination
    public function getPaging($from_user_num, $users_per_page){
        //select query
        $query = "SELECT u.id, u.username, u.password, u.estado, (CASE u.estado WHEN '1' THEN 'ACTIVO' WHEN '0' THEN 'INACTIVO' END)
        AS valor_estado, u.fecha_creacion, p.id AS id_perfil, p.nombre AS nombre_perfil FROM ". $this->table_name ." u
        INNER JOIN perfil p ON u.id_perfil = p.id ORDER BY u.fecha_creacion DESC LIMIT ?, ?";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind variable values
        $stmt->bindParam(1, $from_user_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $users_per_page, PDO::PARAM_INT);

        //execute query
        $stmt->execute();

        //return value from database
        return $stmt;
    }

    //used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM ".$this->table_name. "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}
?>