<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../../models/Apartment.php";

//db connect
$database = new Database();
$db = $database->connect();

//apartment object
$appartment  = new Apartment($db);

//query
$id = isset($_GET['id'])?$_GET['id']:die();
$result = $appartment->read_single($id);

//check if any apartment
$apart_ar = [];
$apart_ar['data'] = [];

if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $apartment_item = [
        'id' => $id,
        'category' => $category,
        'rooms' => $rooms,
        'floor' => $floor,
        'max_floor' => $max_floor,
        'street' => $street,
        'city' => $city,
        'heating' => $heating,
        'furniture' => $furniture,
        'appliances' => $appliances,
        'square' => $square,
        'conditions' => $conditions,
        'created_at' => $created_at
    ];
    //push to data
    array_push($apart_ar['data'], $apartment_item);

    //turn to json
    echo json_encode($apart_ar);
} else {
    echo json_encode(
        ['message' => 'no apartment found']
    );
}
