<?php
class Database_connection
{

    static public function Database_connection()
    {
        return $conn = new mysqli('localhost', 'root', '', 'hotel_system');
    }
}