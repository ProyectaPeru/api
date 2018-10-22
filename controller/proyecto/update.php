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

//get id of law project to be edited
$data = json_decode(file_get_contents("php://input"));

//set ID property of law project to be edited
$proyecto->id = $data->id;

//set law project property values
$proyecto->titulo = $data->titulo;
$proyecto->objeto = $data->objeto;
$proyecto->fundamento = $data->fundamento;
$proyecto->beneficio = $data->beneficio;
$proyecto->departamento = $data->departamento;
$proyecto->id_categoria = $data->id_categoria;
$proyecto->id_usuario = $data->id_usuario;

//update the law project
if($proyecto->update()){
    //set response code - 200 OK
    http_response_code(200);

    //tell the user
    echo json_encode(array("message" => "Law Project was updated."));
}else{
    //set response code - 503 service unavailable
    http_response_code(503);

    //tell the user
    echo json_encode(array("message" => "Unable to update law project."));
}
?>