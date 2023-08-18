<?php
include("../Controller/SmallGradeController.php");
$SmallGradeController = new SmallGradeController(); 

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if($auth != false)
{        
    echo json_encode($SmallGradeController->insertSmallGrade($postData["idLesson"], $postData["idStudent"], $postData["isPlus"], $postData["description"]));
}
else{
    echo "ERROR: Unauthorised.";
}
