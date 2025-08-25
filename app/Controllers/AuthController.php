<?php
require_once('app/Models/user.php');
require_once('configs/database_connection.php');
class AuthController
{
    private $user;
    public function __construct()
    {
        $database = new Database_connection();
        $db = $database->Database_connection();
        $this->user = new User($db);
    }
    // function register account
    public function register()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->first_name) && !empty($data->last_name) && !empty($data->password) && !empty($data->gender) && !empty($data->phone_number)) {
            $this->user->first_name = $data->first_name;
            $this->user->last_name = $data->last_name;
            $this->user->gender = $data->gender;
            $this->user->password = $data->password;
            $this->user->phone_number = $data->phone_number;

            if ($this->user->register()) {
                http_response_code(201);
                echo json_encode(["message" => "User registered successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Registration failed."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Incomplete data."]);
        }
    }
    // function login account
    public function retrieveData()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->phone_number) && !empty($data->password)) {
            $this->user->phone_number = $data->phone_number;
            $this->user->password = $data->password;

            $retrieve = $this->user->retrieveData();
            // var_dump($retrieve); 

            if ($retrieve) {
                // Save session
                // session_start();
                $_SESSION['staff_id'] = $retrieve['staff_id'] ?? '';
                $_SESSION['role'] = $retrieve['role'] ?? '';
                // response data to frontend
                echo json_encode([
                    "message" => "Login successful",
                    "user" => [
                        "staff_id" => $retrieve['staff_id'],
                        "phone_number" => $retrieve['phone_number'],
                        "password" => $retrieve['password'],
                        "role" => $retrieve['role']
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["error" => "Invalid phone_number or password"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Missing phone_number or password"]);
        }
    }
}