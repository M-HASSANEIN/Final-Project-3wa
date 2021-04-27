<?php

class Customers extends ModelManager
{
    public function GetCustomersData()
    {
        $req = "SELECT * FROM `clients`"  ;
        return $this -> queryFetchAll($req);
        
    }

    public function RegisterCustomerDbase($user_name,$firstname,$lastname,$pwd_hashed,$email,$address,$zipcode,$country,$phone)
    {
        $req = "INSERT INTO clients(
                                    `user_name`,
                                    `firstname`,
                                    `lastname`,
                                    `password`,
                                    `email`,
                                    `address`,
                                    `zipcode`,
                                    `country`,
                                    `phone`
                                    ) VALUES(?,?,?,?,?,?,?,?,?)";

         $this -> query($req,[$user_name,$firstname,$lastname,$pwd_hashed,$email,$address,$zipcode,$country,$phone]); 
    }

    public function UserNameExists($user_name)
    {
        $req = "SELECT  `user_name` FROM `clients` WHERE  `user_name` = ?  "  ;
         return $this -> queryFetchAll($req,[$user_name]);
    }

    public function EmailExists($email)
    {
        $req ="SELECT  `email` FROM `clients` WHERE   `email`= ? "  ;
        return $this -> queryFetchAll($req,[$email]);
    }
    //CHECK LOGIN
    public function checkLogIn($user,$email)
    {
        $req = "SELECT  `id_client`,`user_name`,`email`,`password` FROM clients WHERE `user_name` = ? OR  `email`= ? "  ;
        return $this -> queryFetch($req,[$user,$email]);
    }
    //UPDATE CUSOMER PWD
    public function UpDatePWD($pwd,$user,$email)
    {
        $req = "UPDATE  `clients` SET `password` =? WHERE `user_name` = ? OR  `email`= ? "  ;
        return $this -> query($req,[$pwd,$user,$email]);
    }
    //DELETE CUSTOMER BY ID
    public function DeleteCustomer($id)
    {
        $req =
              "DELETE FROM clients WHERE id_client = ?";
               $this -> query($req,[$id]);
    }
    ///GET CUSTOMER BY ID 
    public function GetCustomersDataByID($id)
    {
        $req = "SELECT * FROM `clients` WHERE `id_client` = ?"  ;
        return  $this -> queryFetch($req,[$id]);
        
    }
    ///UPDATE CUSTOMER DATA BY ID 
    public function EditeCustomerData($address,$zipcode,$country,$phone,$id)
    {
        $req = "UPDATE  `clients` SET `address` =?,`zipcode` =?, `country` =? , `phone` =?   WHERE `id_client` = ?"  ;
        return $this -> query($req,[$address,$zipcode,$country,$phone,$id]);
        
    }
}