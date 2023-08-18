<?php
include("../Controller/StudentRatingController.php");
$StudentRatingController = new StudentRatingController();

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if ($auth != false) {
    echo $StudentRatingController->UpdateStudentRatingNote($postData["idStudent"], $postData["idLesson"], $postData["note"]);
} else {
    echo "ERROR: Unauthorised.";
}