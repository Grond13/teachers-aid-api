<?php
include "../Connect.php";


class StudentRatingModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
    }


    function UpdateStudentRating($idStudent, $idLesson, $activityValue)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE `kalivodjo`.`studentrating` set `activityValue` = :activityValue WHERE `Student_idStudent` = :idStudent AND `Lesson_idLesson` = :idLesson"); 
            $stmt->bindParam(':idLesson', $idLesson);
            $stmt->bindParam(':idStudent', $idStudent);
            $stmt->bindParam(':activityValue', $activityValue);            

            $stmt->execute();
            
            return "StudentRating update successful.";
        } catch (PDOException $e) {
            return $e;
        }
    }

    function UpdateStudentRatingNote($idStudent, $idLesson, $note)
    { 
        try {
            $stmt = $this->conn->prepare("UPDATE `kalivodjo`.`studentrating` set `note` = :note WHERE `Student_idStudent` = :idStudent AND `Lesson_idLesson` = :idLesson"); 
            $stmt->bindParam(':idLesson', $idLesson);
            $stmt->bindParam(':idStudent', $idStudent);
            $stmt->bindParam(':note', $note);            

            $stmt->execute();
            
            return "StudentRating update successful.";
        } catch (PDOException $e) {
            return $e;
        }
    }
    function unsetConn()
    {
        $this->conn = null;
    }

}