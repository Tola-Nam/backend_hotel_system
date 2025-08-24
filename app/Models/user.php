<?php
require_once('/Configs/database_connection.php');
class User
{
    // make constructor for connection to database 
    private $conn;
    public function __construct()
    {
        $this->conn = Database_connection::Database_connection();
    }

    // function for register account 

    public function register()
    {

    }
}