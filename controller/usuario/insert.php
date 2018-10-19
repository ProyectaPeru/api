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

//get posted data
$data = json_decode(file_get_contents("php://input"));

//make sure data is not empty
if(
    !empty($data->username) &&
    !empty($data->password) &&
    !empty($data->id_perfil)
){
    //set user property values
    $usuario->username = $data->username;
    $usuario->password = sha1($data->password);
    $usuario->estado = '1';
    $usuario->id_perfil = $data->id_perfil;
    $usuario->fecha_creacion = date('Y-m-d H:i:s');

    //create the user
    if($usuario->insert()){
        //set response code - 201 created
        http_response_code(201);

        //tell the user
        echo json_encode(array("message" => "User was created."));
    }

    //if unable to create the user, tell the user
    else{
        //set reponse code - 503 service unavailable
        http_response_code(503);

        //tell the user
        echo json_encode(array("message" => "Unable to create user."));
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