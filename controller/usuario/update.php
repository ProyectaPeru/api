<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//get database connection
include_once '../../config/database.php';
include_once '../../model/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

//get id of user to be edited
$data = json_decode(file_get_contents("php://input"));

//set ID property of user to be edited
$usuario->id = $data->id;

//set user property values
$usuario->username = $data->username;
$usuario->password = sha1($data->password);
$usuario->estado = $data->estado;
$usuario->id_perfil = $data->id_perfil;

//update the user
if($usuario->update()){
    //set response code - 200 OK
    http_response_code(200);

    //tell the user
    echo json_encode(array("message" => "User was updated."));
}else{
    //set response code - 503 service unavailable
    http_response_code(503);

    //tell the user
    echo json_encode(array("message" => "Unable to update user."));
}
?>