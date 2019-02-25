<?php

/**
 * Description of poi
 *
 * @author tzymni
 */
class Poi {

    private $conn;
    private $table_name = "poi";
    public $name;
    public $lat;
    public $lng;
    public $street;
    public $street_number;
    public $city;
    public $country_code;
    public $is_active;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function getActivePois() {

        $query = "SELECT
                 p.id, p.name, p.lat, p.lng, p.city, p.country_code, p.street, p.street_number
            FROM
                " . $this->table_name . " p
            ORDER BY
                p.id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function add() {


        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, lat=:lat, lng=:lng, city=:city, country_code=:country_code, street=:street, street_number=:street_number, is_active=:is_active ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":name", $this->getName());
        $stmt->bindParam(":lat", $this->getLat());
        $stmt->bindParam(":lng", $this->getLng());
        $stmt->bindParam(":city", $this->getCity());
        $stmt->bindParam(":country_code", $this->getCountryCode());
        $stmt->bindParam(":street", $this->getStreet());
        $stmt->bindParam(":street_number", $this->getStreetNumber());
        $stmt->bindParam(":is_active", $this->getIsActive());


        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function generateAddressFromOpenStreet() {
        
    }

    public function setLat($lat) {
        $this->lat = $lat;
        return $this;
    }

    public function getLat() {
        return $this->lat;
    }

    public function setLng($lng) {
        $this->lng = $lng;
        return $this;
    }

    public function getLng() {
        return $this->lng;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function getIsActive() {
        return $this->is_active;
    }

    public function setIsActive($is_active) {
        $this->is_active = $is_active;
        return $this;
    }

    public function getCity() {
        return $this->city = '1';
    }

    public function getCountryCode() {
        return $this->country_code;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getStreetNumber() {
        return $this->street_number;
    }

}
