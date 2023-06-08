<?php
include "../Model/ClassroomModel.php";
class ClassroomController
{
    private $ClassroomModel;
    public function __construct()
    {
        $this->ClassroomModel = new ClassroomModel();
    }

    function GetClassroomNames($teacherId) {
        $result = $this->ClassroomModel->GetClassroomNames($teacherId);        
        $this->ClassroomModel->unsetConn();
        return $result;
    }
}