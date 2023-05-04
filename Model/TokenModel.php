<?php
class TokenModel
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    function DeleteTeachersTokens($idTeacher){
        $stmt = $this->conn->prepare("DELETE FROM `kalivodjo`.`token` where Teacher_idTeacher = :idTeacher;");
        $stmt->bindParam(':idTeacher', $idTeacher);
    }

    function InsertToken($idTeacher, $token, $validUntil){
        $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`token` (`idToken`, `Teacher_idTeacher`, `token`, `validUntil`) VALUES (null, :idTeacher, :token, :validUntil);");
        $stmt->bindParam(':idTeacher', $idTeacher);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':validUntil', $validUntil);
        
        $stmt->execute();
    }

    function unsetConn(){
        $this->conn = null;
    }

}