<?php

declare(strict_types=1);


require_once './Module/Configs/Database.php';
require_once './Module/Modules/Router.php';
require_once './Module/Models/Product.php';

// required headers
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


// Instantiate DB & connect
$database = new \Module\Configs\Database();
$db = $database->connect();
$router = new \Module\Modules\Router();


$router->get('/', function (){
    echo "HELLO";
});

$router->get('/get', function (){
    global $db;
    $products = new \Module\Models\Product($db);
    $products->get();
});


$router->notFoundHandler(function (){
    echo "Not Found";
});

$router->execute();
