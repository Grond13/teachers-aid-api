<?php
include "../Connect.php";


class ClassroomModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
    }


    function GetClassroomNames($teacherId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT DISTINCT c.idClassroom, c.name FROM `kalivodjo`.`classroom` c
            WHERE c.idTeacher = :idTeacher");

            $stmt->bindParam(':idTeacher', $teacherId);

            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e;
        }
    }

    function insertClassroom($specs, $teacherId)
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`classroom` (`idClassroom`, `name`, `idTeacher`) VALUES (null, :name, :idTeacher)");
            $stmt->bindParam(':name', $specs['classroomName']);
            $stmt->bindParam(':idTeacher', $teacherId);
            $stmt->execute();
            $idClassroom = $this->conn->lastInsertId();

            $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`desk` (`idDesk`, `deskSize`,  `x`, `y`, `isTeachersDesk`,`Classroom_idClassroom`) 
                VALUES (null, :deskSize, :x, :y, :isTeachersDesk, :idClassroom)");
            $stmtSeats = $this->conn->prepare("INSERT INTO `kalivodjo`.`seat` (`idSeat`, `seatNumber`, `Desk_idDesk`) VALUES (null, :seatNumber, :idDesk)");
            
            for ($y = 1; $y <= $specs['rows']; $y++) {
                for ($x = 1; $x <= $specs['columns'] / $specs['deskSize']; $x++) {
                    $stmt->bindParam(':deskSize', $specs['deskSize']);
                    $stmt->bindParam(':x', $x);
                    $stmt->bindParam(':y', $y);
                    $stmt->bindValue(':isTeachersDesk', 0);
                    $stmt->bindParam(':idClassroom', $idClassroom);
                    $stmt->execute();

                    $idDesk = $this->conn->lastInsertId();

                    for ($seatNumber = 1; $seatNumber <= $specs['deskSize']; $seatNumber++) {
                        $stmtSeats->bindParam(':seatNumber', $seatNumber);
                        $stmtSeats->bindParam(':idDesk', $idDesk);
                        $stmtSeats->execute();
                    }
                }
            }

            //Teacher's desk 
            $stmt->bindParam(':deskSize', $specs['deskSize']);
            $stmt->bindParam(':x', $specs['teachersDeskRow']);
            $teachersRow = $specs['rows'] + 1; 
            $stmt->bindParam(':y', $teachersRow);
            $stmt->bindValue(':isTeachersDesk', 1);
            $stmt->bindParam(':idClassroom', $idClassroom);
            $stmt->execute();

            $idDesk = $this->conn->lastInsertId();

            $stmtSeats->bindValue(':seatNumber', 1);
            $stmtSeats->bindParam(':idDesk', $idDesk);
            $stmtSeats->execute();
            //--            

            $this->conn->commit();
            return "Classroom and desks inserted successfully.";
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "ERROR: " . $e->getMessage();
        }
    }    

    function unsetConn()
    {
        $this->conn = null;
    }

}