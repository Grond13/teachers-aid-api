<?php
include("../Controller/LessonTimeController.php");
$LessonTimeController = new LessonTimeController();

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if($auth != false)
{
    echo $LessonTimeController->insertLessonTime($postData["lessonTime"]);
}
else{
    echo "ERROR: Unauthorised.";
}
