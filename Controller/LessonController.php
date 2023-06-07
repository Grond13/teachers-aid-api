<?php

class LessonController
{
    private $LessonModel;
    public function __construct()
    {
        $this->LessonModel = new LessonModel();
    }

    function GetLessonNames($teacherId) {
        return $this->LessonModel->GetLessonNames($teacherId);        
    }
}