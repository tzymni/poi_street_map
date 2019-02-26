<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


// include database and object files
include_once '../config/database.php';
include_once '../model/poi.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$poi = new Poi($db);

$pois = $poi->getActivePois();


$num_poi = $pois->rowCount();

// check if more than 0 record found
if ($num_poi > 0) {


    $pois_arr = array();
    $pois_arr["records"] = array();


    while ($row = $pois->fetch(PDO::FETCH_ASSOC)) {


        extract($row);

        $poi_item = array(
            "id" => $id,
            "name" => $name,
            "lat" => $lat,
            "lng" => $lng,
            "city" => $city,
            "street" => $street,
            "street_number" => $street_number,
            "country_code" => $country_code,
        );

        array_push($pois_arr["records"], $poi_item);
    }

    http_response_code(200);

    echo json_encode($pois_arr);
} else {

    http_response_code(404);

    echo json_encode(
            array("message" => "Brak POI.")
    );
}