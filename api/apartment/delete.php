<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../models/Apartment.php";

//db connect
$database = new Database();
$db = $database->connect();

//apartment object
$appartment  = new Apartment($db);

$data = json_decode(file_get_contents("php://input"));

$appartment->id = $data->id ?? null;

if ($appartment->delete()) {
    echo json_encode(
        ['message' => 'Post deleted']
    );
} else {
    echo json_encode(
        ['message' => 'Post not deleted']
    );
}
