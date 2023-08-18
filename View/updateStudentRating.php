<?php
include("../Controller/StudentRatingController.php");
$StudentRatingController = new StudentRatingController();

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if ($auth != false) {
    echo $StudentRatingController->UpdateStudentRating($postData["idStudent"], $postData["idLesson"], $postData["activityValue"]);
} else {
    echo "ERROR: Unauthorised.";
}