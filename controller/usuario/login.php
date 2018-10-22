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

//get user id
$data = json_decode(file_get_contents("php://input"));

//set ID property of user to be deleted
$usuario->username = $data->username;
$usuario->password = sha1($data->password);

$usuario->login();

if($usuario->id!=null){
    //create array
    $usuario_arr = array(
        "id" => $usuario->id,
        "username" => $usuario->username,
        "estado" => $usuario->estado,
        "fecha_creacion" => $usuario->fecha_creacion,
        "id_perfil" => $usuario->id_perfil,
        "nombre_perfil" => $usuario->nombre_perfil
    );

    if($usuario->estado == 1){
        //set response code -200 OK
        http_response_code(200);

        //make it json format
        echo json_encode($usuario_arr);
    }else{
        //set response code - 404 not found
        http_response_code(404);

        //tell the user, user does not exist
        echo json_encode(array("message" => "The user account is disabled."));
    }

}else{
    //set response code - 404 not found
    http_response_code(404);

    //tell the user, user does not exist
    echo json_encode(array("message" => "Username or password are incorrect."));
}
?>