<?php
include "../Model/StudentModel.php";
class StudentController
{
    private $StudentModel;
    public function __construct()
    {
        $this->StudentModel = new StudentModel();
    }

    function insertAndRegisterStudent($idSeat, $name, $surname, $idLessontime) {                
        $idLesson = $this->StudentModel->getLessonByLessonTime($idLessontime);
        $idStudent = $this->StudentModel->StudentExists($name, $surname, $idLesson);

        if(!$idStudent){
            $idStudent = $this->StudentModel->InsertStudent($name, $surname, $idLesson); 
            $result = $this->StudentModel->RegisterStudent($idStudent, $this->StudentModel->getAllLessonTimesByLesson($idLesson));                             
        }
        
        $result = $this->StudentModel->SeatStudent($idStudent, $idSeat, $idLessontime); 

        $this->StudentModel->unsetConn();        
        return $result; 
    }
}