<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//get database connection
include_once '../../config/database.php';
include_once '../../model/proyecto.php';

$database = new Database();
$db = $database->getConnection();

$proyecto = new Proyecto($db);

//set ID property of law project to read
$proyecto->id = isset($_GET['id'])?$_GET['id']:die();

//read the detail of law project to be edited
$proyecto->getById();

if($proyecto->titulo!=null){
    //create array
    $proyecto_arr = array(
        "id" => $proyecto->id,
        "titulo" => $proyecto->titulo,
        "objeto" => $proyecto->objeto,
        "fundamento" => $proyecto->fundamento,
        "beneficio" => $proyecto->beneficio,
        "departamento" => $proyecto->departamento,
        "estado" => $proyecto->estado,
        "valor_estado" => $proyecto->valor_estado,
        "fecha_creacion" => $proyecto->fecha_creacion,
        "id_categoria" => $proyecto->id_categoria,
        "nombre_categoria" => $proyecto->nombre_categoria,
        "id_usuario" => $proyecto->id_usuario,
        "username_usuario" => $proyecto->username_usuario
    );

    //set response code -200 OK
    http_response_code(200);

    //make it json format
    echo json_encode($proyecto_arr);
}else{
    //set response code - 404 not found
    http_response_code(404);

    //tell the user, law project does not exist
    echo json_encode(array("message" => "Law Project does not exist."));
}
?>