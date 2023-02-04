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

    public function read_single($id)
    {
        $query = "SELECT * FROM ".$this->table." 
        LEFT JOIN 
        categories ON apartment.category_id=categories.id
        WHERE apartment.category_id=? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO ".$this->table." 
        SET
        category_id=:category_id,
        rooms=:rooms,
        floor=:floor,
        max_floor=:max_floor,
        street=:street,
        city=:city,
        heating=:heating,
        furniture=:furniture,
        appliances=:appliances,
        square=:square,
        conditions=:conditions";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(':rooms',$this->rooms);
        $stmt->bindParam(':floor',$this->floor);
        $stmt->bindParam(':max_floor',$this->max_floor);
        $stmt->bindParam(':street',$this->street);
        $stmt->bindParam(':city',$this->city);
        $stmt->bindParam(':heating',$this->heating);
        $stmt->bindParam(':furniture',$this->furniture);
        $stmt->bindParam(':appliances',$this->appliances);
        $stmt->bindParam(':square',$this->square);
        $stmt->bindParam(':conditions',$this->conditions);

        if($stmt->execute()){
            return true;
        }else{
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

    }
}

// $database = new Database;
// $db= $database->connect();
// $apartment = new Apartment($db);
// $ap = $apartment->read_single(1);
// var_dump($ap->fetch(PDO::FETCH_ASSOC));