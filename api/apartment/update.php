<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../models/Apartment.php";

//db connect
$database = new Database();
$db = $database->connect();

//apartment object
$appartment  = new Apartment($db);

$data = json_decode(file_get_contents("php://input"));
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$pattern='~^\/real_estate\/api\/apartment\/(\d+)(.*)$~';
preg_match($pattern,$uri,$matches);
$id = intval($matches[1]);

$appartment->id = $id ?? null;
$appartment->category_id = $data->category_id ?? null;
$appartment->rooms = $data->rooms ?? null;
$appartment->floor = $data->floor ?? null;
$appartment->max_floor = $data->max_floor ?? null;
$appartment->street = $data->street ?? null;
$appartment->city = $data->city ?? null;
$appartment->heating = $data->heating ?? null;
$appartment->furniture = $data->furniture ?? null;
$appartment->appliances = $data->appliances ?? null;
$appartment->square = $data->square ?? null;
$appartment->conditions = $data->conditions ?? null;

if ($appartment->update()) {
    echo json_encode(
        ['message' => 'Post updated']
    );
} else {
    echo json_encode(
        ['message' => 'Post not updated']
    );
}
