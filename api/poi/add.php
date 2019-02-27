<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../model/poi.php';




$data = (object) $_POST;

$database = new Database();
$db = $database->getConnection();

$poi = new Poi($db);


if (
        !empty($data->name) &&
        !empty($data->lat) &&
        !empty($data->lng)
) {

    if (empty($poi->validateLongitude($data->lng))) {
        http_response_code(400);
        echo json_encode(array("message" => "Wrong longitude"));
        die();
    }

    if (empty($poi->validateLatitude($data->lat))) {
        http_response_code(400);
        echo json_encode(array("message" => "Wrong latitude"));
        die();
    }

    $poi = $poi->setLat($data->lat)->setLng($data->lng)->setName($data->name)->setIsActive(1);

    //generate address data 
    $poi->generateAddressFromOpenStreet();

    if ($poi->add()) {

        http_response_code(201);
        echo json_encode(array("message" => "POI created."));
    } else {

        http_response_code(503);
        echo json_encode(array("message" => "Error, POI cannot be create"));
    }
} else {

    http_response_code(400);
    echo json_encode(array("message" => "All required data is needed"));
}
