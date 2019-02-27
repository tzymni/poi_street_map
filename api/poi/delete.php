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

$id = $data->id;

if ($id > 0) {

    $poi = new Poi($db);
    $poi->setId($id);

    if ($poi->delete()) {

        http_response_code(200);
        echo json_encode(array("message" => "POI deleted."));
    } else {

        http_response_code(503);
        echo json_encode(array("message" => "Cant delete POI."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "ID its required."));
}
