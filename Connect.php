<?php

if(!isset($_SESSION['idTeacher'])){
    //session_start();
}
class Connect
{
/*
    private static $servername = "localhost";
    private static $username = "kalivodjo";
    private static $password = "KrAKeN-25.8.2000";
    private static $dbname = "kalivodjo";
*/
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "kalivodjo";


    public static function connect()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow, and if so:

            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 1000');
        }
        else{
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
            }
            exit(0);
        }

        try {
            $conn = new PDO("mysql:host=". self::$servername . "; dbname=" . self::$dbname, self::$username , self::$password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo 'Connection successful <br>';
            return $conn;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}