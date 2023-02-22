<?php
//require 'connection.php'; // $conn
/*
//$conn = connect();
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow, and if so:

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 1000');
}
else{
    //die();
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
*/

include "Connect.php";

$connect = new Connect();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kalivodjo";

try {
    /*$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
    $conn = $connect->Connect();

    echo 'Connection successful <br>';

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

/*
include "Connect.php";

$conn = Connect::connect();
*/
try {
    $stmt = $conn->prepare("select name from Teacher where idTeacher = 1");
    //$stmt->bindParam(':idTeacher', $_POST['idTeacher']);

    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $response = $stmt->fetchAll();

    foreach ($response as $item){
        echo json_encode($item);
    }

}
catch (PDOException $e) {
    echo "getTestId failed: " . $e->getMessage();
}

$conn = null;