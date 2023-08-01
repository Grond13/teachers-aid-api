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

    function updateLessonTime($LessonTime)
    {
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

function insertLessonTime($LessonTime)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO `lessontime` (`idLessonTime`, `start`, `end`, `day`, `note`, `editableUntil`, `Lesson_idLesson`, `Classroom_idClassroom`) VALUES (null, :start, :end, :day, :note, :editableUntil, :idLesson, :idClassroom)");

            $stmt->bindParam(':start', $LessonTime['start']);
            $stmt->bindParam(':end', $LessonTime['end']);
            $stmt->bindParam(':day', $LessonTime['day']);
            $stmt->bindParam(':note', $LessonTime['note']);
            $stmt->bindParam(':editableUntil', $LessonTime['editableUntil']);              
            $stmt->bindParam(':idLesson', $LessonTime['idLesson']);
            $stmt->bindParam(':idClassroom', $LessonTime['idClassroom']);

            $stmt->execute();

            return "SUCCESS: Created successfully.";
        } catch (PDOException $e) {
            return $e;
        }
    }

    function deleteLessonTime($idLessonTime)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM `lessontime` WHERE idLessonTime = :idLessonTime");
        
            $stmt->bindParam(':idLessonTime', $idLessonTime);
    
            $stmt->execute();
    
            return "SUCCESS: Deleted successfully.";
        } catch (PDOException $e) {
            return $e;
        }
    }
    
    function getTeachingSession($idLessonTime) {
        $idLesson = $this->getLessonByLessonTime($idLessonTime);

        try {
            $stmt = $this->conn->prepare("
                SELECT st.idStudent, st.name, st.surname, s.idSeat, sr.activityValue, sr.note                      
                FROM `lessonTime` l                                
                INNER JOIN `student_has_lessontime` slt ON l.idLessontime = slt.lessontime_idLessontime         
                INNER JOIN `student` st ON slt.Student_idStudent = st.idStudent
                INNER JOIN `seat` s on st.idStudent = s.student_idStudent
                INNER JOIN `studentRating` sr on st.idStudent = sr.student_idStudent
                WHERE l.idLessonTime = :idLessonTime 
            "); // TODO: functional but not correct, should be checking idLesson too

            $stmt->bindParam(':idLessonTime', $idLessonTime);
                
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e;
        }
    }

    function addRatings($idLessonTime, $students) {
        $idLesson = $this->getLessonByLessonTime($idLessonTime);
            
        try {
            $stmt = $this->conn->prepare("
                SELECT sg.StudentRating_Student_idStudent, sg.isPlus, sg.description, sg.date                                 
                FROM `smallGrade` sg                                  
                WHERE sg.studentRating_Lesson_idLesson = :idLesson
                ORDER BY sg.StudentRating_Student_idStudent, sg.date
            ");        
            $stmt->bindParam(':idLesson', $idLesson);
                   
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $smallGrades = $stmt->fetchAll();
    
            $smallGradesByStudent = array();
            foreach ($smallGrades as $smallGrade) {
                $idStudent = $smallGrade['StudentRating_Student_idStudent'];
                $smallGradesByStudent[$idStudent][] = $smallGrade;
            }
    
            foreach ($students as &$student) {
                $idStudent = $student['idStudent'];
                if (isset($smallGradesByStudent[$idStudent])) {
                    $student['smallGrades'] = $smallGradesByStudent[$idStudent];
                } else {
                    $student['smallGrades'] = array();
                }
            }
    
            return $students;            
        } catch (PDOException $e) {
            return $e;
        }
    }
    
    
    function getLayout($idLessonTime) {
        try {
            $stmt = $this->conn->prepare("
                SELECT s.idSeat, s.seatNumber, d.y as 'row', d.x as 'column', d.isTeachersDesk, d.idDesk                               
                FROM `seat` s                
                INNER JOIN `desk` d ON s.Desk_idDesk = d.idDesk
                INNER JOIN `classroom` c ON d.Classroom_idClassroom = c.idClassroom                 
                INNER JOIN `lessontime` l ON c.idClassroom = l.Classroom_idClassroom                        
                WHERE l.idLessonTime = :idLessonTime
                ORDER BY d.y, d.x 
            ");
        
            $stmt->bindParam(':idLessonTime', $idLessonTime);
                
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e;
        }
    }    

    function getLessonByLessonTime($idLessonTime){
        try {
            $stmt = $this->conn->prepare("SELECT l.idLesson from `lesson` l INNER JOIN lessonTime lt on l.idLesson = lt.Lesson_idLesson WHERE lt.idLessonTime = :idLessonTime");
        
            $stmt->bindParam(':idLessonTime', $idLessonTime);
                
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetch()['idLesson'];
        } catch (PDOException $e) {
            return $e;
        }
    }

    function unsetConn()
    {
        $this->conn = null;
    }
}