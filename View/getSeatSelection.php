<?php
include("../Controller/LessonTimeController.php");
$LessonTimeController = new LessonTimeController();

$postData = json_decode(file_get_contents("php://input"), true);

echo json_encode($LessonTimeController->GetSeatSelection($postData["lessonTime"]));
