<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//get database connection
include_once '../../config/core.php';
include_once '../../config/database.php';
include_once '../../model/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

//get keywords
$keywords = isset($_GET['s']?$_GET['s']:"");

//query users
$stmt = $usuario->search($keywords);
$num = $stmt->rowCount();

//check if more than 0 uer found
if($num>0){
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
            "nombre_perfil" => $nombre_perfil
        );

        array_push($usuario_arr['users'], $usuario_item);
    }

    //set response code 200 - OK
    http_response_code(200);

    //show users data
    echo json_encode($usuario_arr);
}else{
    //set response code - 404 Not found
    http_response_code(404);

    //tell the user no users found
    echo json_encode(array("message" => "No users found."));
}
?>