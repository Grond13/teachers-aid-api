<?php

class Connect
{

    private static $servername = "localhost";
    private static $username = "webAccess";
    private static $password = "iDunnoM8";
    private static $dbname = "kalivodjo";
    
    public static function connectToDb()
    {
    
        try {
            $conn = new PDO("mysql:host=" . self::$servername . "; dbname=" . self::$dbname, self::$username, self::$password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'Connection successful <br>';

            return $conn;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }            
    }
}