<?php
include "../Connect.php";


class TeacherModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connect::connectToDb();
    }

    function GetTeacherByEmail($email){
        $stmt = $this->conn->prepare("SELECT * FROM `kalivodjo`.`teacher` where email = :email;");
        $stmt->bindParam(':email', $email);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    function InsertTeacher($name, $surname, $email, $password){
        $stmt = $this->conn->prepare("INSERT INTO `kalivodjo`.`teacher` (`idTeacher`, `name`, `surname`, `email`, `password`) VALUES (null, :name, :surname, :email, :password);");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hash);
        $stmt->execute();
    }

    function unsetConn(){
        $this->conn = null;
    }

}