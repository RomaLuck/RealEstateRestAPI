<?php
namespace real_estate\config;

use PDO;
use PDOException;

require_once __DIR__."/../config.php";

class Database
{
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try{
        $this->conn = new PDO("mysql:host=localhost;dbname=real_estate",username,password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Connection Error". $e->getMessage();
        }
        return $this->conn;
    }
}