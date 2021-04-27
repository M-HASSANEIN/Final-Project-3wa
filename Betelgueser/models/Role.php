<?php

class Role extends ModelManager
{
    public function GetALLRole()
    {
        $req =
               "SELECT * FROM `role`" ;
               
                return $this -> queryFetchAll($req);
    }
   
}