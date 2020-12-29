<?php
// required headers
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

// get id of client 
$data = json_decode(file_get_contents("php://input"));

$client->id = $data->id;

// set client property values
$client->first_name = $data->first_name;
$client->last_name = $data->last_name;
$client->email = $data->email;
$client->phone = $data->phone;
$client->category = $data->category;

// update 
if($client->update()){
    //200 ok
    http_response_code(200);
    echo json_encode(array("message" => "client was updated."));
}
// if unable to update the client
else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update client."));
}
?>