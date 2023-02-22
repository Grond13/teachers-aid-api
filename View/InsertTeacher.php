<?php
/*
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow, and if so:

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 10');
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
*/

include "../Controller/TeacherController.php";

$TeacherController = new TeacherController();

try {

    $data = json_decode(file_get_contents("php://input"), true);    

    if(isset($data['name']) && isset($data['surname']) && isset($data['email']) && isset($data['password'])){
        $TeacherController->InsertTeacher($data['name'], $data['surname'], $data['email'], $data['password']);
    }
    else{
        echo "Error: parametres incomplete";
    }
}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
    //$stmt->bindParam(':idTeacher', $_POST['idTeacher']);
/*
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $response = $stmt->fetchAll();

    foreach ($response as $item){
        echo json_encode($item);
    }

}


$conn = null;
*/

