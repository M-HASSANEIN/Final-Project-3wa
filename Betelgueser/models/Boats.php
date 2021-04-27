<?php
class Boats extends ModelManager
{
    public function GetBoat()
    {
        $req =
              "SELECT * FROM `boat`"  ;
               return $this -> queryFetch($req);
    }

    public function AddBoat($boat_name,$company_name,$address,$email,$phone,$logo)
    {
         $req =
               " INSERT INTO boat(`boat_name`,`company_name`,`address`,`info_email`,`company_phone`,`logo`) VALUES (?,?,?,?,?,?)";
                 $this -> query($req,[$boat_name,$company_name,$address,$email,$phone,$logo]);
    }

    public function DeleteBoat($id)
    {
        $req =
              "DELETE FROM boat WHERE id_boat = ?";
               $this -> query($req,[$id]);
    }
     //call boat by id boat
    public function CallBoatbyId($id)
    {
        $req = 
              " SELECT *
                FROM boat
                WHERE id_boat=?";
                return $this -> queryFetch($req,[$id]);
    }
    //update  all boat info  in data base
    public function  UpDateBoatDbase($boat_name,$company_name,$address,$email,$phone,$logo,$id)
    {
        $req =
              "UPDATE boat SET boat_name=?, company_name=?,`address`=?,`info_email`=?,`company_phone`=?,`logo`=? WHERE id_boat=?";
               return  $this -> query($req,[$boat_name,$company_name,$address,$email,$phone,$logo,$id]);
    }
    ////update boat name 
    public function  UpDateThisBoatDbase($boat_name,$company_name,$address,$email,$phone,$id)
    {
        $req =
              "UPDATE boat SET boat_name=?,company_name=?,`address`=?,`info_email`=?,`company_phone`=? WHERE id_boat=?";
               return  $this -> query($req,[$boat_name,$company_name,$address,$email,$phone,$id]);
    }



}