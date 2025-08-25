<?php
// require_once('Configs/database_connection.php');
class User
{
    // make constructor for connection to database 
    private $conn;
    private $table = "staffs";
    public $first_name, $last_name, $gender, $password, $role, $phone_number;
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // function for register account 

    public function register()
    {
        // Prepare query with ? placeholders
        $queryRegister = "INSERT INTO " . $this->table . " (`first_name`, `last_name`, `gender`, `password`,`phone_number`) 
                      VALUES (?, ?, ?, ?,? )";

        $stmt = $this->conn->prepare($queryRegister);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        // Clean input
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

        // Bind parameters (all strings here)
        $stmt->bind_param(
            "sssss",
            $this->first_name,
            $this->last_name,
            $this->gender,
            $this->password,
            $this->phone_number
        );

        // Execute and return result
        if ($stmt->execute()) {
            return true;
        } else {
            // Debug error
            echo "Execute failed: " . $stmt->error;
            return false;
        }
    }

    // function retrieve user 

    public function retrieveData()
    {
        $retrieveQuery = "SELECT staff_id,phone_number, gender, role, password FROM " . $this->table . " WHERE phone_number = ? LIMIT 1";
        $stmt = $this->conn->prepare($retrieveQuery);


        if (!$stmt) {
            die('prepare fail' . $this->conn->error);
        }

        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $stmt->bind_param("s", $this->phone_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify password
        if ($user && $this->password === $user['password']) {
            return $user;
        }


        return false;
    }

}