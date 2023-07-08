<?php

include "../Model/TokenModel.php";

class AuthenticationController
{
    private $TokenModel;
    public function __construct()
    {
        $this->TokenModel = new TokenModel();
    }

    function AuthenticateToken($token) {
        $responseToken = $this->TokenModel->getToken($token);
    
        //var_dump($responseToken);

        $validUntil = new DateTime($responseToken["validUntil"]);
        $now = new DateTime();
            
        $this->TokenModel->unsetConn();

        if ($validUntil > $now) {   
            return $responseToken["Teacher_idTeacher"];
        } else {
            return false;
        }
    }
}