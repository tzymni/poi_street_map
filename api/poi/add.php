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

    $poi = $poi->setLat($data->lat)->setLng($data->lng)->setName($data->name)->setIsActive(1);

    $poi->generateAddressFromOpenStreet();

    if ($poi->add()) {

        http_response_code(201);
        echo json_encode(array("message" => "POI zostało utworzone."));
    } else {

        http_response_code(503);
        echo json_encode(array("message" => "Coś poszło nie tak, POI nie zostało utworzone"));
    }
} else {

    http_response_code(400);
    echo json_encode(array("message" => "Brak wymaganych danych do utworzenia POI"));
}
