<?php

require_once __DIR__."/../config/Database.php";
require_once __DIR__."/controllers/ApartmantController.php";
require_once __DIR__."/models/Apartment.php";
require_once __DIR__."/../config/ErrorHandler.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if ($parts[3] != "apartment") {
    http_response_code(404);
    exit;
}

$id = $parts[4] ?? null;

$database = new Database;
$db = $database->connect();
$apartment = new Apartment($db);
$controller = new ApartmentController($apartment);
$controller->request($_SERVER["REQUEST_METHOD"], $id);
