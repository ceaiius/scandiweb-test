<?php

declare(strict_types=1);

require_once './Module/Configs/Database.php';
require_once './Module/Modules/Router.php';
require_once './Module/Models/Product.php';

// Headers
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


// Instantiate DB & connect

$database = new \Module\Configs\Database();
$db = $database->connect();
$router = new \Module\Modules\Router();

// Get Products

$router->get('/get', function (){
    global $db;
    $products = new \Module\Models\Product($db);
    $products->get();
});

// Add Products

$router->post('/add', function () {
    global $db;
    $json = json_decode(file_get_contents('php://input'), true);
    $data = json_decode($json['body'], true);

    $product = new \Module\Models\Product($db);

    foreach ($data as $key => $value) {
        if (property_exists($product, $key)) {
            $product->$key = $value;
        }
    }

    $product->create();
});

// Delete Products

$router->post('/delete', function (){
    global $db;
    $json = json_decode(file_get_contents('php://input'), true);
    $product = new \Module\Models\Product($db);
    foreach($json['body'] as $id){
        $product->delete($id);
    }
});

$router->notFoundHandler(function (){
    echo "Not Found";
});

$router->execute();
