<?php

declare(strict_types=1);

require_once './App/Config/Database.php';
require_once './App/Modules/Router.php';
require_once './App/Models/Product.php';
require_once __DIR__ . '/vendor/autoload.php';

// Headers

header('Access-Control-Allow-Origin: https://nika-mamaladze-scandiweb.netlify.app');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// Instantiate DB & connect

$database = new \App\Config\Database();
$db = $database->connect();
$router = new \App\Modules\Router();

$router->get('/', function (){
    echo "HELLO";
});

// Get Products

$router->get('/get', function (){
    global $db;
    $products = new \App\Models\Product($db);
    $products->get();
});

// Add Products

$router->post('/add', function () {
    global $db;
    $json = json_decode(file_get_contents('php://input'), true);
    $data = json_decode($json['body'], true);

    $product = new \App\Models\Product($db);

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
    $product = new \App\Models\Product($db);
    foreach($json['body'] as $id){
        $product->delete($id);
    }
});

$router->notFoundHandler(function (){
    echo "Not Found";
});

$router->execute();
