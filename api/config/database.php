<?php



/**
 * Description of databse
 *
 * @author tzymni
 */
class Database {


    private $host = "localhost";
    private $db_name = "poi_open_street";
    private $username = "root";
    private $password = "123456";
    public $conn;

    // get the database connection
    public function getConnection() : PDO{

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}
