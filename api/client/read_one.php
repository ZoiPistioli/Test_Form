<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/client.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);
 
// set ID property of record to read
$client->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details 
$client->readOne();

if($client->first_name!=null){
    $client_arr=array(
        "id" => $client->id,
        "first_name" => $client->first_name,
        "last_name" => $client->last_name,
        "email" => $client->email,
        "phone" => $client->phone,
        "category" => $client->category
    );
    // 200 OK
    http_response_code(200);
    echo json_encode($client_arr);
}
else{
    // 404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "Client does not exist."));
}
?>