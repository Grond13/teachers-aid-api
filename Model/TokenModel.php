<?php
class TokenModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connect();
    }

    function DeleteTeachersTokens($idTeacher){
        $stmt = $this->conn->prepare("DELETE FROM `kalivodjo`.`token` where Teacher_idTeacher = :idTeacher;");
        $stmt->bindParam(':idTeacher', $idTeacher);

        $stmt->execute();
    }

    function InsertToken($idTeacher, $token, $validUntil){
        $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`token` (`idToken`, `Teacher_idTeacher`, `token`, `validUntil`) VALUES (null, :idTeacher, :token, :validUntil);");
        $stmt->bindParam(':idTeacher', $idTeacher);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':validUntil', $validUntil);
        
        $stmt->execute();
    }

    function getToken($token){
        $stmt = $this->conn->prepare("SELECT * FROM `kalivodjo`.`token` where token = :token;");
        $stmt->bindParam(':token', $token);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetch();
    }

    function unsetConn(){
        $this->conn = null;
    }

}