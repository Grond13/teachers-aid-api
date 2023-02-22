<?php

include "../Model/TeacherModel.php";

class TeacherController
{
    private $TeacherModel;
    public function __construct()
    {
        $this->TeacherModel = new TeacherModel();
    }

    function InsertTeacher($name, $surname, $email, $password){
        // Check
        if(count($this->TeacherModel->GetTeacherByEmail($email)) == 0){
            $this->TeacherModel->InsertTeacher($name, $surname, $email, $password);
            echo "Teacher added.";
        }
        else{
            // TODO: errorMessage
            echo "email already used";
        }
        $this->TeacherModel->unsetConn();
    }
}