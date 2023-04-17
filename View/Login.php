<?php

//session_start();  
//print_r($_SESSION);

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
            session_start();            
            $_SESSION['idTeacher'] = $pole[1];                        
            echo "session:";
            /*echo "Session ID: " . session_id();*/
            print_r($_SESSION);
        } else
            echo "Invalid email or password.";
    } catch (PDOException $e) {
        echo "Unexpected error." . $e->getMessage();
    }
} else
    echo 'Missing email or password.';