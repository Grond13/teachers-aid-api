<?php

session_start();
//echo ini_get('session.save_path');
//echo "Session ID: " . session_id();
//print_r($_SESSION);

//include("../Controller/LessonController.php");
include("../Controller/LessonTimeController.php");
//include("../Controller/ClassroomController.php");

//$LessonController = new LessonController();
$LessonTimeController = new LessonTimeController();
//$ClassroomController = new ClassroomController();

/*
if (!isset($_SESSION['idTeacher']))
    die("user not set");
else {
    echo "success";//json_encode($LessonTimeController->getTimeTable($_SESSION['idTeacher'])[0]);
}*/



echo json_encode($LessonTimeController->GetTimetable(12));