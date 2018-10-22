<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//get database connection
include_once '../../config/core.php';
include_once '../../shared/utilities.php';
include_once '../../config/database.php';
include_once '../../model/usuario.php';

//utilities
$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

//query users
$stmt = $usuario->getPaging($from_user_num, $users_per_page);
$num = $stmt->rowCount();

//check if more than 0 user found
if($num>0){
    //User Array
    $usuario_arr = array();
    $usuario_arr["users"] = array();
    $usuario_arr["paging"] = array();

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

    //include paging
    $total_rows = $usuario->count();
    $page_url="{$home_url}product/getPaging?";
    $paging=$utilities->getPaging($page, $total_rows, $users_per_page, $page_url);
    $usuario_arr["paging"]=$paging;

    //set response code 200 - OK
    http_response_code(200);

    //make it json format
    echo json_encode($usuario_arr);
}else{
    //set response code - 404 Not found
    http_response_code(404);

    //tell the user no users found
    echo json_encode(array("message" => "No users found."));
}
?>