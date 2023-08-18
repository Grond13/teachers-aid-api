<?php
include "../Connect.php";


class LessonModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
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
    function InsertLesson($idTeacher, $name)
    {
        $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`lesson` (`idLesson`, `name`, `Teacher_idTeacher`) 
            VALUES (null, :name, :idTeacher);");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':idTeacher', $idTeacher);
        $stmt->execute();
        return "Lesson added.";
    }

    function unsetConn()
    {
        $this->conn = null;
    }

}