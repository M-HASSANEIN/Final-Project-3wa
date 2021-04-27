<?php

class Newletter extends ModelManager
{
    public function EmailandnameExists($name,$email)
    {
        $req ="SELECT  `name`,`email` FROM `newletter` WHERE  `name`= ? AND `email`= ? "  ;
        return $this -> queryFetch($req,[$name,$email]);
    }

   
    public function JionNewletter($name,$email)
    {
        $req = "INSERT INTO newletter(
                                     `name`,
                                     `email`
                                     ) VALUES(?,?)";

         $this -> query($req,[$name,$email]); 
    }
    public function StopNewletter($name,$email)
    {
        $req =
                "DELETE FROM `newletter` WHERE  `name`= ? AND `email`= ?";
                
                $this -> query($req,[$name,$email]);
    }



}