<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '~^\/real_estate\/api\/apartment\/create$~'=>"apartment/create.php",
    '~^\/real_estate\/api\/apartment\/(\d+)\/delete$~'=>"apartment/delete.php",
    '~^\/real_estate\/api\/apartment\/(\d+)$~'=>"apartment/read_single.php",
    '~^\/real_estate\/api\/apartment\/$~'=>"apartment/read.php",
    '~^\/real_estate\/api\/apartment\/(\d+)\/update$~'=>"apartment/update.php"
];

function route_to_controller($uri,$routes)
{
    foreach($routes as $key=>$value){
        if(preg_match($key,$uri)){
            require_once $value;
        }
    }
}

function abort($code = 404)
{
    http_response_code($code);
    echo json_encode("Page not found");
    die();
}

route_to_controller($uri,$routes);