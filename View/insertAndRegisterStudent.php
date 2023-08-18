<?php
include("../Controller/StudentController.php");
$StudentController = new StudentController();

$postData = json_decode(file_get_contents("php://input"), true);

echo $StudentController->insertAndRegisterStudent($postData["idSeat"], $postData["name"], $postData["surname"], $postData["idLessonTime"]);    
 