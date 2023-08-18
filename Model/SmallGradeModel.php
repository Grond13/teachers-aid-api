<?php
include "../Connect.php";


class SmallGradeModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
    }


    function InsertSmallGrade($idLesson, $idStudent, $isPlus, $description)
    {
     try {            
            $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`smallgrade` (`idSmallGrade`, `StudentRating_Student_idStudent`, `StudentRating_Lesson_idLesson`, `isPlus`, `description`) 
                VALUES (null, :idStudent, :idLesson, :isPlus, :description);");
            $stmt->bindParam(':idLesson', $idLesson);
            $stmt->bindParam(':idStudent', $idStudent);
            $stmt->bindParam(':isPlus', $isPlus);
            $stmt->bindParam(':description', $description);

            $stmt->execute();


            $stmt = $this->conn->prepare("
                SELECT `idSmallGrade`, `isPlus`, `description`, DATE_FORMAT(`date`, '%d. %m. %Y') AS date
                    FROM `kalivodjo`.`smallgrade`
                    WHERE `StudentRating_Student_idStudent` = :idStudent && `StudentRating_Lesson_idLesson` = :idLesson
            ");

            $stmt->bindParam(':idLesson', $idLesson);
            $stmt->bindParam(':idStudent', $idStudent);

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