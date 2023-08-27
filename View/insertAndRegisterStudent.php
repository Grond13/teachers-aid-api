<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../Controller/StudentController.php");
$StudentController = new StudentController();

$postData = json_decode(file_get_contents("php://input"), true);

//print_r($postData);

echo $StudentController->insertAndRegisterStudent($postData["idSeat"], $postData["name"], $postData["surname"], $postData["idLessonTime"]);    
 