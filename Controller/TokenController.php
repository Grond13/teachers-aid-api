<?php

include "../Model/TokenModel.php";

class TokenController
{
    private $TokenModel;
    public function __construct()
    {
        $this->TokenModel = new TokenModel();
    }
    
    public function SetNewToken($idTeacher){
        $this->TokenModel->DeleteTeachersTokens($idTeacher);
    
        $validUntil = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $token = uniqid();
    
        $this->TokenModel->InsertToken($idTeacher, $token, $validUntil);
    
        $this->TokenModel->unsetConn();
        return $token;
    }
    

}