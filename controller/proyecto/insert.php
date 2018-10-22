<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//get database connection
include_once '../../config/database.php';
include_once '../../model/proyecto.php';

$database = new Database();
$db = $database->getConnection();

$proyecto = new Proyecto($db);

//get posted data
$data = json_decode(file_get_contents("php://input"));

//make sure data is not empty
if(
    !empty($data->titulo) &&
    !empty($data->objeto) &&
    !empty($data->fundamento) &&
    !empty($data->beneficio) &&
    !empty($data->departamento) &&
    !empty($data->id_categoria) &&
    !empty($data->id_usuario)
){
    //set law project property values
    $proyecto->titulo = $data->titulo;
    $proyecto->objeto = $data->objeto;
    $proyecto->fundamento = $data->fundamento;
    $proyecto->beneficio = $data->beneficio;
    $proyecto->departamento = $data->departamento;
    $proyecto->estado = '1';
    $proyecto->id_categoria = $data->id_categoria;
    $proyecto->id_usuario = $data->id_usuario;
    $proyecto->fecha_creacion = date('Y-m-d H:i:s');

    //create the law project
    if($proyecto->insert()){
        //set response code - 201 created
        http_response_code(201);

        //tell the user
        echo json_encode(array("message" => "Law Project was created."));
    }

    //if unable to create the law project, tell the user
    else{
        //set reponse code - 503 service unavailable
        http_response_code(503);

        //tell the user
        echo json_encode(array("message" => "Unable to create law project."));
    }
}

//tell the user data is incomplete
else{
    //set response code - 400 bad request
    http_response_code(400);

    //tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>