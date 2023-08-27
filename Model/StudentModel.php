<?php
include "../Connect.php";


class StudentModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
    }

    function RegisterStudent($idStudent, $LessonTimes){
        try {
            $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`student_has_lessontime` (`Student_idStudent`, `LessonTime_idLessonTime`) VALUES (:idStudent, :idLessonTime);");

            $stmt->bindParam(':idStudent', $idStudent);

            foreach ($LessonTimes as $idLessonTime) {
                $stmt->bindParam(':idLessonTime', $idLessonTime["idLessonTime"]);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            return $e;
        }
    }

    function SeatStudent($idStudent, $idSeat, $idLessonTime)
    {        
        if(!$this->StudentIsRegistered($idStudent, $idLessonTime)){

            $this->RegisterStudent($idStudent, array(0 => array("idLessonTime" => $idLessonTime)));
        }

        $stmt = $this->conn->prepare("SELECT * FROM `kalivodjo`.`seat` s where s.idSeat = :idSeat");
        $stmt->bindParam(':idSeat', $idSeat);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $seat = $stmt->fetch();

        print_r($seat);

        if ($seat['Student_idStudent'] == null) {
            try {
                $stmt = $this->conn->prepare("UPDATE `kalivodjo`.`seat` set Student_idStudent = :idStudent WHERE idSeat = :idSeat");
                $stmt->bindParam(':idStudent', $idStudent);
                $stmt->bindParam(':idSeat', $idSeat);

                $stmt->execute();
                
                return "Empty seat updated successfully.";
            } catch (PDOException $e) {
                return $e;
            }
        } else {
            return "Seat is not empty";
        }
    }

    function StudentIsRegistered($idStudent, $idLessonTime){
        try {
            $stmt = $this->conn->prepare("SELECT Student_idStudent as idStudent from student_has_lessontime
            WHERE LessonTime_idLessonTime = :idLessonTime AND Student_idStudent = :idStudent");
    
            $stmt->bindParam(':idLessonTime', $idLessonTime);
            $stmt->bindParam(':idStudent', $idStudent);            
    
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);            

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function InsertStudent($name, $surname, $idLesson)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`student` (`idStudent`, `name`, `surname`) VALUES (null, :name, :surname);");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);

            $stmt->execute();

            $idStudent = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`studentrating` (`Student_idStudent`, `Lesson_idLesson`, `activityValue`) VALUES (:idStudent, :idLesson, :activityValue);");
            $stmt->bindParam(':idStudent', $idStudent);
            $stmt->bindParam(':idLesson', $idLesson);
            $stmt->bindValue(':activityValue', 5);

            $stmt->execute();

            echo "Student inserted.\n";

            return $idStudent;
        } catch (PDOException $e) {
            return $e;
        }
    }

    function getAllLessonTimesByLesson($idLesson)
    {
        try {
            $stmt = $this->conn->prepare("SELECT lt.idLessonTime from `lessontime` lt INNER JOIN lesson l on l.idLesson = lt.Lesson_idLesson WHERE l.idLesson = :idLesson");

            $stmt->bindParam(':idLesson', $idLesson);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e;
        }
    }

    function getLessonByLessonTime($idLessonTime)
    {
        try {
            $stmt = $this->conn->prepare("SELECT l.idLesson from `lesson` l INNER JOIN lessontime lt on l.idLesson = lt.Lesson_idLesson WHERE lt.idLessonTime = :idLessonTime");

            $stmt->bindParam(':idLessonTime', $idLessonTime);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetch()['idLesson'];
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function StudentExists($name, $surname, $idLesson)
    {
        try {
            $stmt = $this->conn->prepare("SELECT s.idStudent from `lesson` l 
            INNER JOIN lessontime lt on l.idLesson = lt.Lesson_idLesson            
            INNER JOIN student_has_lessontime slt on slt.LessonTime_idLessonTime = lt.idLessonTime 
            INNER JOIN student s on slt.Student_idStudent = s.idStudent
            WHERE l.idLesson = :idLesson AND s.name = :name AND s.surname = :surname");
    
            $stmt->bindParam(':idLesson', $idLesson);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);
    
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            print_r($result);            

            if ($result) {
                return $result['idStudent'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    

    function unsetConn()
    {
        $this->conn = null;
    }

}