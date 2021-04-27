<?php

class ResetPWD extends ModelManager 
{
    public function InsertRestdata($code,$email,$expires)
    {
        $req=
        
              "INSERT INTO reset_passwords(code,email,code_reset_expire) VALUES (?,?,?)";
              
              $this -> query($req,[$code,$email,$expires]);
       
    } 
    
    public function CodeexistinDatabase($code)
    {
        $req =
              "SELECT  `code`,`email`,`code_reset_expire` FROM `reset_passwords` WHERE  `code`= ?  "  ;
               return $this -> queryFetch($req,[$code]);
    }
    public function DeleteCodeDbase($email)
    {
        $req =
              "DELETE FROM reset_passwords WHERE email = ?";
              
              $this -> query($req,[$email]);
    }


}