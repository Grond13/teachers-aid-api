<?php


include("../Controller/LessonTimeController.php");
$LessonTimeController = new LessonTimeController();

echo json_encode($LessonTimeController->GetTimetable(12));