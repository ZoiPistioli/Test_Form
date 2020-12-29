<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/client.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);

// get data
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->email) &&
    !empty($data->phone) &&
    !empty($data->category)
){
    $client->first_name = $data->first_name;
    $client->last_name = $data->last_name;
    $client->email = $data->email;
    $client->phone = $data->phone;
    $client->category = $data->category;

    $idres=$client->create();

    if($idres){
        //  201 
        http_response_code(201);
        echo json_encode(array(
            "message" => "Client registration completed.",
            "id" => $idres
        ));
    }
    // if unable to create the client
    else{
        // 503 service unavailable
        http_response_code(503);
        echo json_encode(array("message" => "Unable to register client."));
    }
}
else{
    400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to register client. Data is incomplete."));
}
?>