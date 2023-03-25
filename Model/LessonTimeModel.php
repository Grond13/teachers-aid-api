<?php
include "../Connect.php";


class LessonTimeModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connect();
    }

    
    function GetTimetable($teacherId)
    {
        
        try {
            $stmt = $this->conn->prepare("SELECT lt.idLessonTime, l.name, lt.start, lt.end, lt.day, lt.note, lt.editableUntil, c.idClassroom, c.name as 'classroom' FROM `kalivodjo`.`lesson` l 
            inner join `kalivodjo`.`lessontime` lt on l.idLesson = lt.Lesson_idLesson 
            inner join `kalivodjo`.`classroom` c on c.idClassroom = lt.Classroom_idClassroom 
            WHERE l.Teacher_idTeacher = :idTeacher
            order by lt.`day`;");
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