<?php
require_once('app/Models/type_room.php');
require_once('configs/database_connection.php');
class Room_type
{
    private $room_type;

    public function __construct()
    {
        $database_connection = new Database_connection();
        $db = $database_connection->database_connection();
        $this->room_type = new Type_room($db);
    }
    // function create room type
    public function createRoomType()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->room_number) && !empty($data->price) && !empty($data->status) && !empty($data->room_type) && !empty($data->description)) {

            $this->room_type->room_number = htmlspecialchars(strip_tags($data->room_number));
            $this->room_type->price = (float) $data->price;
            $this->room_type->status = htmlspecialchars(strip_tags($data->status));
            $this->room_type->room_type = htmlspecialchars(strip_tags($data->room_type));
            $this->room_type->description = htmlspecialchars(strip_tags($data->description));

            if ($this->room_type->create_roomType()) {
                http_response_code(201);
                echo json_encode(["message" => "Room type created successfully"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Failed to create room type"]);
            }

        } else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data"]);
        }
    }

    // function update room type

    public function updateRoomType()
    {
        // Get JSON input from request
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data)) {
            // Set properties in model
            $this->room_type->room_number = htmlspecialchars(strip_tags($data->room_number ?? ''));
            $this->room_type->price = (float) ($data->price ?? 0);
            $this->room_type->status = htmlspecialchars(strip_tags($data->status ?? 'availble'));
            $this->room_type->room_type = htmlspecialchars(strip_tags($data->room_type ?? ''));
            $this->room_type->description = htmlspecialchars(strip_tags($data->description ?? ''));
            $this->room_type->id = (int) $data->id;

            if ($this->room_type->updateTypeRoom()) {
                http_response_code(200);
                echo json_encode(['message' => 'Room type updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update room type']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid input. Please provide room ID and data to update.']);
        }
    }

}