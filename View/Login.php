<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../Connect.php");
$conn = Connect::connectToDb();  

include("../Controller/TokenController.php");
$TokenController = new TokenController();

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["email"]) && !empty($data["password"])) {

    $email = $data["email"];
    $pass = $data["password"];   

    try {
        $stmt = $conn->prepare("SELECT `password`, `idTeacher`, `name`, `surname`, `email` from teacher where `email` = :email ");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_NUM);
        $responseArray = $stmt->fetch();

        $hash = $responseArray[0];
        $conn = null;
        if (password_verify($pass, $hash)) {            
            echo $TokenController->SetNewToken($responseArray[1]);                        
        } else
            echo "ERROR: Authentification failed.";
    } catch (PDOException $e) {
        echo "ERROR: Unexpected error." . $e->getMessage();
    }
} else
    echo "ERROR: Unexpected error.";

$conn = null;
