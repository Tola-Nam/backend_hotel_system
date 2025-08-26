<?php
session_start();
// include file in controller
require_once "app/Controllers/AuthController.php";
require_once('Configs/database_connection.php');
require_once('core/router.php');
require_once('app/Controllers/check_in.php');
require_once('app/Controllers/booking.php');
require_once('app/Controllers/room.php');
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
// make object in controller
$userController = new AuthController();
$router = new Router();
// $booking = new Booking();
// $checkIn = new Check_in();
$addRoom = new Room_type();
// Routes  for register account
$router->add(method: "POST", path: "/retrieveData", callback: function () use ($userController): void {
    $userController->retrieveData();
});

$router->add(method: "POST", path: "/register", callback: function () use ($userController) {
    $data = json_decode(file_get_contents("php://input"), associative: true);
    $userController->register();
});

// route for make room type
$router->add(method: "POST", path: "/createRoomType", callback: function () use ($addRoom) {
    $data = json_decode(file_get_contents("php://input"), associative: true);
    $addRoom->createRoomType();
});
$router->add(method: "PUT", path: "/UpdateRoomType", callback: function () use ($addRoom) {
    $addRoom->UpdateRoomType();
});

// Run
$router->router();