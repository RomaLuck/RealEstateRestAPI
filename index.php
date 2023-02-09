<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/real_estate/api/apartment/create'=>"api/apartment/create.php",
    '/real_estate/api/apartment/delete'=>"api/apartment/delete.php",
    '/real_estate/api/apartment/{$id}'=>"api/apartment/read_single.php",
    '/real_estate/api/apartment/'=>"api/apartment/read.php",
    '/real_estate/api/apartment/update'=>"api/apartment/update.php"
];

function route_to_controller($uri,$routes)
{
    if(array_key_exists($uri,$routes)){
        require_once $routes[$uri];
    }else{
        return abort();
    }
}

function abort($code = 404)
{
    http_response_code($code);
    echo json_encode("Page not found");
    die();
}

route_to_controller($uri,$routes);