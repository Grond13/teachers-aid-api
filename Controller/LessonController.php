<?php
include "../Model/LessonModel.php";
class LessonController
{
    private $LessonModel;
    public function __construct()
    {
        $this->LessonModel = new LessonModel();
    }

    function GetLessonNames($teacherId) {
        $result = $this->LessonModel->GetLessonNames($teacherId);        
        $this->LessonModel->unsetConn();        
        return $result;
    }

    function InsertLesson($teacherId, $name) {
        $result = $this->LessonModel->insertLesson($teacherId, $name);         
        $this->LessonModel->unsetConn();        
        return $result;
    }
}