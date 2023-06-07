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
            $stmt = $this->conn->prepare("SELECT lt.idLessonTime, l.name, lt.start, lt.end, lt.day, lt.note, lt.editableUntil, c.idClassroom, c.name as 'classroom', l.idLesson FROM `kalivodjo`.`lesson` l 
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

    function updateLessonTime($LessonTime ){
        try {                                             
            
            $stmt = $this->conn->prepare("UPDATE LessonTime SET day = :day, start = :start, end = :end, note = :note, editableUntil = :editableUntil, Classroom_idClassroom = :idClassroom, Lesson_idLesson = :idLesson WHERE idLessonTime = :idLessonTime");
                      
            $stmt->bindParam(':day', $LessonTime['day']);
            $stmt->bindParam(':start', $LessonTime['start']);
            $stmt->bindParam(':end', $LessonTime['end']);          
            $stmt->bindParam(':note', $LessonTime['note']);          
            $stmt->bindParam(':editableUntil', $LessonTime['editableUntil']);              
            $stmt->bindParam(':idClassroom', $LessonTime['idClassroom']);
            $stmt->bindParam(':idLesson', $LessonTime['idLesson']);            
            $stmt->bindParam(':idLessonTime', $LessonTime['idLessonTime']);
                                  
            $stmt->execute();
                                  
            return "SUCCESS: Updated successfully.";
          } catch (PDOException $e) {                    
            return $e;
          }
    }

    function unsetConn()
    {
        $this->conn = null;
    }

}