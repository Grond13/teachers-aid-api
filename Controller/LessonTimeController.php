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
        $result = $this->LessonTimeModel->GetTimeTable($idTeacher);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }
    
    function updateLessonTime($LessonTime){
        $result = $this->LessonTimeModel->updateLessonTime($LessonTime);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }

    function insertLessonTime($LessonTime){
        $result = $this->LessonTimeModel->insertLessonTime($LessonTime);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }

    function deleteLessonTime($idLessonTime){
        $result = $this->LessonTimeModel->deleteLessonTime($idLessonTime);
        $this->LessonTimeModel->unsetConn();
        return $result;
    }
}