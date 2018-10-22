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

//get user id
$data = json_decode(file_get_contents("php://input"));

//set ID property of user to be deleted
$proyecto->id = $data->id;

//delete the law project
if($proyecto->delete()){
    //set response code - 200 OK
    http_response_code(200);

    //tell the law project
    echo json_encode(array("message" => "Law Project was deleted."));
}else{
    //set response code - 503 service unavailable
    http_response_code(503);

    //tell the user
    echo json_encode(array("message" => "Unable to delete Law Project."));
}
?>