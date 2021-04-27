<?php

class UserBack extends ModelManager
{   //get all user to show in page users 
    public function GetALLUsers()
    {
        $req =
               "SELECT * FROM `users-back` 
                INNER JOIN `role` ON `role`.id_role= `users-back`.id_role 
                ORDER BY id_user "  ;
                return $this -> queryFetchAll($req);
    }
     ///to check user is exits and connect
    public function getData($verfyAdmin,$user)
    {
        $req =
               "SELECT *
                FROM `users-back` 
                INNER JOIN `role` ON `role`.id_role= `users-back`.id_role 
                WHERE email=? OR `user_name`=?
                ORDER BY id_user "  ;
                return $this -> queryFetch($req, [$verfyAdmin,$user]);
    }

     //ADD NEW USER TO DATA BASE
    public function AddUsertoDbase($id_role,$username,$firstname,$lastname,$pwd,$email)
    {
        $req=
              "INSERT INTO `users-back`(id_role,`user_name`,firstname,lastname,pass_word,email) VALUES (?,?,?,?,?,?)";
               $this -> query($req,[$id_role,$username,$firstname,$lastname,$pwd,$email]);
       
    }
    //call user by id 
    public function CallUserbyId($id)
    {
        $req = 
                 " SELECT *
                   FROM `users-back` 
                   INNER JOIN `role` ON `role`.id_role= `users-back`.id_role 
                   WHERE `users-back`.id_user=?";
                  
          return  $this -> queryFetch($req,[$id]);

    }
    //DELETE USER BY ID 
    public function DeleteUserDbase($id)
    {
        $req =
                "DELETE FROM `users-back`  WHERE id_user=?";
                
                $this -> query($req,[$id]);
    }


    //UPdate room with out photo
    public function UpDateUSERDbase($id_role,$username,$firstname,$lastname,$email,$id)
    {
        $req =
                "UPDATE `users-back` SET id_role=?,`user_name`=?,firstname=?,lastname=?,email=? WHERE id_user= ?";
                
         return  $this -> query($req,[$id_role,$username,$firstname,$lastname,$email,$id]);
    }
}