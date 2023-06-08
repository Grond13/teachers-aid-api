<?php
include "../Connect.php";


class LessonModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connect();
    }

    
    function GetLessonNames($teacherId)
    {        
        try {
            $stmt = $this->conn->prepare("SELECT DISTINCT l.idLesson, l.name FROM `kalivodjo`.`lesson` l                         
            WHERE l.Teacher_idTeacher = :idTeacher");

            $stmt->bindParam(':idTeacher', $teacherId);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e;
        }
    }

    function unsetConn()
    {
        $this->conn = null;
    }

}