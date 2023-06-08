<?php
include "../Connect.php";


class ClassroomModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connect();
    }

    
    function GetClassroomNames($teacherId)
    {        
        try {
            $stmt = $this->conn->prepare("SELECT DISTINCT c.idClassroom, c.name FROM `kalivodjo`.`Classroom` c
            INNER JOIN `kalivodjo`.`LessonTime` lt on c.idClassroom = lt.Classroom_idClassroom
            INNER JOIN `kalivodjo`.`Lesson` l on lt.Lesson_idLesson = l.idLesson
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