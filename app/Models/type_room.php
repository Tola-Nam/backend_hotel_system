<?php
class Type_room
{
    private $conn;
    private $table = "rooms";
    public $room_number, $price, $status, $room_type, $description,$id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // create room type
    public function create_roomType()
    {
        try {
            $createRoomType = "INSERT INTO " . $this->table . " (`room_number`, `price`, `status`, `room_type`, `description`)
                               VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($createRoomType);
            if (!$stmt) {
                die("Query prepare failed: " . $this->conn->error);
            }

            // Clean input
            $this->room_number = htmlspecialchars(strip_tags($this->room_number));
            $this->price = (float) $this->price;
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->room_type = htmlspecialchars(strip_tags($this->room_type));
            $this->description = htmlspecialchars(strip_tags($this->description));

            // Bind params
            $stmt->bind_param(
                "sdsss",
                $this->room_number,
                $this->price,
                $this->status,
                $this->room_type,
                $this->description
            );

            // Execute
            if ($stmt->execute()) {
                return true;
            } else {
                echo 'Create failed: ' . $stmt->error;
                return false;
            }
        } catch (Exception $e) {
            echo json_encode([
                "message" => "fail",
                "data" => $e->getMessage()
            ]);
        }
    }

    // function retrieve data 
    public function retrieveDataRoom()
    {

    }
    // function update 

    public function updateTypeRoom()
    {
        $updateRoomType = "UPDATE " . $this->table . " 
                       SET `room_number` = ?, 
                           `price` = ?, 
                           `status` = ?, 
                           `room_type` = ?, 
                           `description` = ? 
                       WHERE `room_id` = ?";

        $stmt = $this->conn->prepare($updateRoomType);
        // var_dump(
        //     $this->room_number,
        //     $this->price,
        //     $this->status,
        //     $this->room_type,
        //     $this->description,
        //     $this->id
        // );

        // Clean input
        $this->room_number = htmlspecialchars(strip_tags($this->room_number));
        $this->price = (float) $this->price;
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->room_type = htmlspecialchars(strip_tags($this->room_type));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $id = (int) $this->id;

        $stmt->bind_param(
            "sdsssi",
            $this->room_number,
            $this->price,
            $this->status,
            $this->room_type,
            $this->description,
            $this->id
        );

        return $stmt->execute();
    }


}
