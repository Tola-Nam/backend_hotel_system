<?php
session_start();
// include file in controller
require_once "app/Controllers/AuthController.php";
require_once('Configs/database_connection.php');
require_once('core/router.php');

// header api json
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// debug connection database 
// $db = new Database_connection();
// if ($db) {
//     return $db;

// }
$userController = new AuthController();
$router = new Router();

// Routes
$router->add("GET", "/api/users", [$userController, "index"]);
$router->add("POST", "/api/users", function () use ($userController) {
    $data = json_decode(file_get_contents("php://input"), true);
    $userController->register();
});
$router->add("PUT", "/api/users", function () use ($userController) {
    $data = json_decode(file_get_contents("php://input"), true);
    $userController->login();
});
$router->add("DELETE", "/api/users/(\d+)", function ($id) use ($userController) {
    // $userController->destroy($id);
});

// Run
$router->router();