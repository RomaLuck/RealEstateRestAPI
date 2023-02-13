<?php
namespace real_estate\api\controllers;

use real_estate\api\models\Apartment;

require_once __DIR__."/../../vendor/autoload.php";

class ApartmentController
{
    public function __construct(private Apartment $gateway)
    {
        
    }

    public function request(string $method, ?string $id):void
    {
        if($id){
            $this->resourse_request($method,$id);
        }else{
            $this->collect_request($method);
        }
    }

    public function resourse_request(string $method, string $id):void
    {
        $apartment = $this->gateway->read_single($id);
        if ( ! $apartment) {
            http_response_code(404);
            echo json_encode(["message" => "Apartment not found"]);
            return;
        }
        switch($method){
            case "GET":
                echo json_encode($apartment);
                break;
            
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"),true);
                $rows = $this->gateway->update($apartment,$data);
                echo json_encode([
                    "message" => "Apartment $id updated",
                    "rows" => $rows
                ]);
                break;
            
            case "DELETE":
                $rows = $this->gateway->delete($id);
                echo json_encode([
                    "message" => "Apartment $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
            http_response_code(405);
            header("Allow: GET, PATCH, DELETE");
        }
    }

    public function collect_request(string $method):void
    {
        switch($method){
            case "GET":
                echo json_encode($this->gateway->read());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $id = $this->gateway->create($data);
                http_response_code(201);
                echo json_encode([
                    "message" => "Apartment created",
                    "id" => $id
                ]);
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }
}