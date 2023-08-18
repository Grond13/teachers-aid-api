<?php
include "../Model/SmallGradeModel.php";
class SmallGradeController
{
    private $SmallGradeModel;
    public function __construct()
    {
        $this->SmallGradeModel = new SmallGradeModel();
    }

    function insertSmallGrade($idLesson, $idStudent, $isPlus, $description) {                               
        $result = $this->SmallGradeModel->InsertSmallGrade($idLesson, $idStudent, $isPlus, $description);   

        $this->SmallGradeModel->unsetConn();        

        return $result; 
    }
}