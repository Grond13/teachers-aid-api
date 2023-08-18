<?php

include("../Controller/LessonController.php");
$LessonController = new LessonController();

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if($auth != false)
{   
    echo json_encode($LessonController->InsertLesson($auth, $postData["name"])); 
}
else{
    echo "ERROR: Unauthorised."; 
}
