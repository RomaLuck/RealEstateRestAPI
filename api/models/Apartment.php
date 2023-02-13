<?php
namespace real_estate\api\models;

use PDO;

require_once __DIR__ . "/../../config/Database.php";

class Apartment
{
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
    public function read(): array
    {
        $query = "SELECT * FROM " . $this->table . " 
        LEFT JOIN 
        categories ON apartment.category_id=categories.category_id
        ORDER BY 
        apartment.created_at DESC";

        $stmt = $this->conn->query($query);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function read_single(string $id): array |false
    {
        $query = "SELECT * FROM " . $this->table . " 
        LEFT JOIN 
        categories ON apartment.category_id=categories.category_id
        WHERE apartment.id=:id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function create(array $data): string | false
    {
        $query = "INSERT INTO " . $this->table . " 
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
        $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':rooms', $data['rooms'], PDO::PARAM_INT);
        $stmt->bindValue(':floor', $data['floor'], PDO::PARAM_INT);
        $stmt->bindValue(':max_floor', $data['max_floor'], PDO::PARAM_INT);
        $stmt->bindValue(':street', $data['street'], PDO::PARAM_STR);
        $stmt->bindValue(':city', $data['city'], PDO::PARAM_STR);
        $stmt->bindValue(':heating', $data['heating'], PDO::PARAM_STR);
        $stmt->bindValue(':furniture', $data['furniture'], PDO::PARAM_BOOL);
        $stmt->bindValue(':appliances', $data['appliances'], PDO::PARAM_BOOL);
        $stmt->bindValue(':square', $data['square'], PDO::PARAM_INT);
        $stmt->bindValue(':conditions', $data['conditions'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function update(array $current, array $new): int | false
    {
        $query = "UPDATE " . $this->table . " 
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
        conditions=:conditions 
        WHERE 
        id=:id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':category_id', $new['category_id'] ?? $current['category_id'],PDO::PARAM_INT);
        $stmt->bindValue(':rooms', $new['rooms'] ?? $current['rooms'],PDO::PARAM_INT);
        $stmt->bindValue(':floor', $new['floor'] ?? $current['floor'],PDO::PARAM_INT);
        $stmt->bindValue(':max_floor', $new['max_floor'] ?? $current['max_floor'],PDO::PARAM_INT);
        $stmt->bindValue(':street', $new['street'] ?? $current['street'],PDO::PARAM_STR);
        $stmt->bindValue(':city', $new['city'] ?? $current['city'],PDO::PARAM_STR);
        $stmt->bindValue(':heating', $new['heating'] ?? $current['heating'],PDO::PARAM_STR);
        $stmt->bindValue(':furniture', $new['furniture'] ?? $current['furniture'],PDO::PARAM_BOOL);
        $stmt->bindValue(':appliances', $new['appliances'] ?? $current['appliances'],PDO::PARAM_BOOL);
        $stmt->bindValue(':square', $new['square'] ?? $current['square'],PDO::PARAM_INT);
        $stmt->bindValue(':conditions', $new['conditions'] ?? $current['conditions'],PDO::PARAM_STR);
        $stmt->bindValue(':id', $current['id'],PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function delete(string $id): int | false
    {
        $query = "DELETE FROM " . $this->table . " 
        WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            return $stmt->rowCount();
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}