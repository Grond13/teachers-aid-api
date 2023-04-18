<?php

session_start();
require("../Connect.php");

$conn = Connect::connect();

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["email"]) && !empty($data["password"])) {

    $email = $data["email"];
    $pass = $data["password"];
    try {
        $stmt = $conn->prepare("SELECT `password`, `idTeacher`, `name`, `surname`, `email` from Teacher where `email` = :email ");

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_NUM);
        $pole = $stmt->fetch();

        $hash = $pole[0];

        if (password_verify($pass, $hash)) {
            $_SESSION['idTeacher'] = $pole[1];
            echo true;
        } else
            echo false;
    } catch (PDOException $e) {
        echo "Unexpected error." . $e->getMessage();
    }
} else
    echo false;
