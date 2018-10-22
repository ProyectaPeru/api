<?php
class Proyecto{
    private $conn;
    private $table_name = "proyecto";

    //object properties
    public $id;
    public $titulo;
    public $objeto;
    public $fundamento;
    public $beneficio;
    public $departamento;
    public $estado;
    public $valor_estado;
    public $fecha_creacion;
    public $id_categoria;
    public $nombre_categoria;
    public $id_usuario;

    //constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //getAll law project
    function getAll(){
        //select all query
        $query = "SELECT p.id, p.titulo, p.objeto, p.fundamento, p.beneficio, p.departamento, p.estado, (CASE p.estado WHEN '1' THEN 'ACTIVO'
                    WHEN '0' THEN 'INACTIVO' END) AS valor_estado, p.fecha_creacion, c.id AS id_categoria, c.nombre AS nombre_categoria
                    FROM ". $this->table_name ." p INNER JOIN categoria c ON p.id_categoria = c.id ORDER BY p.fecha_creacion DESC";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //create law project
    function insert(){
        //query to insert law project
        $query = "INSERT INTO ".$this->table_name." SET titulo=:titulo, objeto=:objeto, fundamento=:fundamento, beneficio=:beneficio,
                    departamento=:departamento, estado=:estado, fecha_creacion=:fecha_creacion, id_categoria=:id_categoria,
                    id_usuario=:id_usuario";
        //prepare query
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->objeto = htmlspecialchars(strip_tags($this->objeto));
        $this->fundamento = htmlspecialchars(strip_tags($this->fundamento));
        $this->beneficio = htmlspecialchars(strip_tags($this->beneficio));
        $this->departamento = htmlspecialchars(strip_tags($this->departamento));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));

        //bind values
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":objeto", $this->objeto);
        $stmt->bindParam(":fundamento", $this->fundamento);
        $stmt->bindParam(":beneficio", $this->beneficio);
        $stmt->bindParam(":departamento", $this->departamento);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":id_usuario", $this->id_usuario);

        //execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //used when filling up the update law project form
    function getById(){
        //query to read single law project
        $query = "SELECT p.id, p.titulo, p.objeto, p.fundamento, p.beneficio, p.departamento, p.estado, (CASE p.estado WHEN '1' THEN 'ACTIVO'
        WHEN '0' THEN 'INACTIVO' END) AS valor_estado, p.fecha_creacion, c.id AS id_categoria, c.nombre AS nombre_categoria
        FROM ". $this->table_name ." p INNER JOIN categoria c ON p.id_categoria = c.id ORDER BY p.fecha_creacion DESC AND p.id = ? LIMIT 0,1";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind id of user to be updated
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();

        //get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to object properties
        $this->titulo = $row['titulo'];
        $this->objeto = $row['objeto'];
        $this->fundamento = $row['fundamento'];
        $this->beneficio = $row['beneficio'];
        $this->departamento = $row['departamento'];
        $this->estado = $row['estado'];
        $this->valor_estado = $row['valor_estado'];
        $this->fecha_creacion = $row['fecha_creacion'];
        $this->id_categoria = $row['id_categoria'];
        $this->nombre_categoria = $row['nombre_categoria'];
    }

    function update(){
        //update query
        $query = "UPDATE ".$this->table_name." SET titulo=:titulo, objeto=:objeto, fundamento=:fundamento, beneficio=:beneficio,
                    departamento=:departamento, estado=:estado, fecha_creacion=:fecha_creacion, id_categoria=:id_categoria,
                    id_usuario=:id_usuario";
        
        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->objeto = htmlspecialchars(strip_tags($this->objeto));
        $this->fundamento = htmlspecialchars(strip_tags($this->fundamento));
        $this->beneficio = htmlspecialchars(strip_tags($this->beneficio));
        $this->departamento = htmlspecialchars(strip_tags($this->departamento));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));

        //bind values
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":objeto", $this->objeto);
        $stmt->bindParam(":fundamento", $this->fundamento);
        $stmt->bindParam(":beneficio", $this->beneficio);
        $stmt->bindParam(":departamento", $this->departamento);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":id_usuario", $this->id_usuario);
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

}
?>