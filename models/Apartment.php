<?php
require_once __DIR__."/../config/Database.php";

class Apartment{
    private $conn;
    private $table = 'apartment';

    //properties:
    public $id;
    public $category_id;
    public $rooms;
    public $floor;
    public $max_floor;
    public $street;
    public $city;
    public $heating;
    public $furniture;
    public $appliances;
    public $square;
    public $conditions;
    public $created_at;

    //constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get apartment
    public function read()
    {
        $query = "SELECT * FROM ".$this->table." 
        LEFT JOIN 
        categories ON apartment.category_id=categories.id
        ORDER BY 
        apartment.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
// $database = new Database();
// $db = $database->connect();
// $apart = new Apartment($db);
// $result =$apart->read();
// var_dump($result->fetchAll());