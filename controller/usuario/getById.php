<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

//get database connection
include_once '../../config/database.php';
include_once '../../model/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

//set ID property of user to read
$usuario->id = isset($_GET['id'])?$_GET['id']:die();

//read the detail of user to be edited
$usuario->getById();

if($usuario->username!=null){
    //create array
    $usuario_arr = array(
        "id" => $usuario->id,
        "username" => $usuario->username,
        "password" => $usuario->password,
        "estado" => $usuario->estado,
        "valor_estado" => $usuario->valor_estado,
        "fecha_creacion" => $usuario->fecha_creacion,
        "id_perfil" => $usuario->id_perfil,
        "nombre_perfil" => $usuario->nombre_perfil
    );

    //set response code -200 OK
    http_response_code(200);

    //make it json format
    echo json_encode($usuario_arr);
}else{
    //set response code - 404 not found
    http_response_code(404);

    //tell the user, user does not exist
    echo json_encode(array("message" => "User does not exist."));
}
?>