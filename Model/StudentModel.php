<?php
include "../Connect.php";


class StudentModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
    }

    function RegisterStudent($idStudent, $LessonTimes, $idSeat)
    {
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
            try {
                $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`seat` (`idSeat`, `Student_idStudent`, `Desk_idDesk`, `seatNumber`) VALUES (null, :idStudent, :idDesk, :seatNumber)");
                $stmt->bindParam(':idStudent', $idStudent);
                $stmt->bindParam(':idDesk', $seat['Desk_idDesk']);
                $stmt->bindParam(':seatNumber', $seat['seatNumber']);

                $stmt->execute();

                return "New seat inserted successfully.";
            } catch (PDOException $e) {
                return $e;
            }
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

            $stmt->setFetchMode(PDO::FETCH_DEFAULT);

            if ($stmt->fetchAll() != null)
                return true;
            else
                return false;
        } catch (PDOException $e) {
            echo $e;
        }
    }
    function unsetConn()
    {
        $this->conn = null;
    }

}