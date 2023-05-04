<?php

//session_start();
require("../Connect.php");
$conn = Connect::connect();

include("../Controller/TokenController.php");
$TokenController = new TokenController($conn);

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["email"]) && !empty($data["password"])) {

    $email = $data["email"];
    $pass = $data["password"];   

    try {
        $stmt = $conn->prepare("SELECT `password`, `idTeacher`, `name`, `surname`, `email` from Teacher where `email` = :email ");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_NUM);
        $responseArray = $stmt->fetch();

        $hash = $responseArray[0];

        if (password_verify($pass, $hash)) {
            //$_SESSION['idTeacher'] = $pole[1];
            echo $TokenController->SetNewToken($responseArray[1]);                        
        } else
            echo "ERROR: Authentification failed.";
    } catch (PDOException $e) {
        echo "ERROR: Unexpected error." . $e->getMessage();
    }
} else
    echo "ERROR: Unexpected error.";
