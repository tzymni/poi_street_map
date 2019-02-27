<?php

include_once '../utills/cUrl.php';

/**
 *
 *
 * @author tzymni
 */
class Poi {

    private $conn;
    private $table_name = "poi";
    public $id;
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
                    WHERE p.is_active = 1
            ORDER BY
                p.id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function delete() {

        $query = "UPDATE " . $this->table_name . " set is_active = 0 WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->getId());

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function add() {


        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, lat=:lat, lng=:lng, city=:city, country_code=:country_code, street=:street, street_number=:street_number, is_active=:is_active ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindValue(":name", $this->getName());
        $stmt->bindValue(":lat", $this->getLat());
        $stmt->bindValue(":lng", $this->getLng());
        $stmt->bindValue(":city", $this->getCity());
        $stmt->bindValue(":country_code", $this->getCountryCode());
        $stmt->bindValue(":street", $this->getStreet());
        $stmt->bindValue(":street_number", intval($this->getStreetNumber()));
        $stmt->bindValue(":is_active", $this->getIsActive());

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * generate address data by api openstreetmap
     */
    public function generateAddressFromOpenStreet() {

        if (!empty($this->getLat()) && !empty($this->getLng())) {

            $url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' . $this->getLat() . '&lon=' . $this->getLng() . '&addressdetails=1';

            $curl = new CUrl();
            $json = $curl->curlRun($url);
            $arr = json_decode($json, true);

            if (count($arr) > 0) {

                $address = $arr['address'];

                if (!empty($address['country_code'])) {
                    $this->setCountryCode($address['country_code']);
                }
                if (!empty($address['city'])) {
                    $this->setCity($address['city']);
                }
                if (!empty($address['road'])) {
                    $this->setStreet($address['road']);
                }
                if (!empty($address['house_number'])) {
                    $this->setStreetNumber($address['house_number']);
                }
            }
        }
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
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getCountryCode() {
        return $this->country_code;
    }

    public function setCountryCode($country_code) {
        $this->country_code = $country_code;
        return $this;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;
        return $this;
    }

    public function getStreetNumber() {
        return $this->street_number;
    }

    public function setStreetNumber($street_number) {
        $this->street_number = $street_number;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function validateLongitude($lng) {
        return preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/', $lng);
    }

    public function validateLatitude($lat) {
        return preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/', $lat);
    }

}
