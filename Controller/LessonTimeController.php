<?php

include "../Model/LessonTimeModel.php";

class LessonTimeController
{
    private $LessonTimeModel;
    public function __construct()
    {
        $this->LessonTimeModel = new LessonTimeModel();
    }

    function GetTimetable($idTeacher){
        return $this->LessonTimeModel->GetTimeTable($idTeacher);
    }
}