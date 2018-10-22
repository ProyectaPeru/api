<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once '../../config/database.php';
include_once '../../model/proyecto.php';

//instantiate database and law project object
$database = new Database();
$db = $database->getConnection();

//initialize object
$proyecto = new Proyecto($db);

//query law projects
$stmt = $proyecto->getAll();
$num = $stmt->rowCount();

//Check if more tha 0 users found
if($num > 0){

    //Law Project Array
    $proyecto_arr = array();
    $proyecto_arr["projects"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extraxt row
        //this wil make $row['titulo'] to
        //just $titulo only
        extract($row);

        $proyecto_item = array(
            "id" => $id,
            "titulo" => $titulo,
            "objeto" => $objeto,
            "fundamento" => $fundamento,
            "beneficio" => $beneficio,
            "departamento" => $departamento,
            "estado" => $estado,
            "valor_estado" => $valor_estado,
            "fecha_creacion" => $fecha_creacion,
            "id_categoria" => $id_categoria,
            "nombre_categoria" => $nombre_categoria,
            "id_usuario" => $id_usuario
        );

        array_push($proyectp_arr['projects'], $proyecto_item);
    }

    //set response_code - 200 OK
    http_response_code(200);

    //show projects data in jon format
    echo json_encode($proyecto_arr);
}else{
    //set response code - 404 not found
    http_response_code(404);

    //tell the user no users found
    echo json_encode(
        array("message" => "No projects found.")
    );
}
?>