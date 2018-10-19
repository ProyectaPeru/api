<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once '../../config/database.php';
include_once '../../model/usuario.php';

//instantiate database and product object
$database = new Database();
$db = $database->getConnection();

//initialize object
$usuario = new Usuario($db);

//query usuarios
$stmt = $usuario->getAll();
$num = $stmt->rowCount();

//Check if more tha 0 users found
if($num > 0){

    //User Array
    $usuario_arr = array();
    $usuario_arr["users"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extraxt row
        //this wil make $row['username'] to
        //just $username only
        extract($row);

        $usuario_item = array(
            "id" => $id,
            "username" => $username,
            "password" => $password,
            "estado" => $estado,
            "valor_estado" => $valor_estado,
            "fecha_creacion" => $fecha_creacion,
            "id_perfil" => $id_perfil,
            "nombre_perfil" => $nombre_perfil,
        );

        array_push($usuario_arr['users'], $usuario_item);
    }

    //set response_code - 200 OK
    http_response_code(200);

    //show usuarios data in jon format
    echo json_encode($usuario_arr);
}else{
    //set response code - 404 not found
    http_response_code(404);

    //tell the user no users found
    echo json_encode(
        array("message" => "No user found.")
    );
}
?>