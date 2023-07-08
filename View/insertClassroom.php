<?php
include("../Controller/ClassroomController.php");
$ClassroomController = new ClassroomController();

include("../Controller/AuthenticationController.php");
$AuthenticationController = new AuthenticationController();

$postData = json_decode(file_get_contents("php://input"), true);

$auth = $AuthenticationController->AuthenticateToken($postData["token"]);

if($auth != false)
{
    echo $postData["specs"]["columns"];
}
else{
    echo "ERROR: Unauthorised.";
}
