<?php
include "../Model/StudentRatingModel.php";
class StudentRatingController
{
    private $StudentRatingModel;
    public function __construct()
    {
        $this->StudentRatingModel = new StudentRatingModel();
    }

    function UpdateStudentRating($idStudent, $idLesson, $activityValue) {                        
        
        $result = $this->StudentRatingModel->UpdateStudentRating($idStudent, $idLesson, $activityValue); 

        $this->StudentRatingModel->unsetConn();        
        return $result; 
    }

    function UpdateStudentRatingNote($idStudent, $idLesson, $note) {                        
        
        $result = $this->StudentRatingModel->UpdateStudentRatingNote($idStudent, $idLesson, $note); 

        $this->StudentRatingModel->unsetConn();        
        return $result; 
    }
}