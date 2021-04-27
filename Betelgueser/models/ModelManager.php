<?php

class ModelManager
{
    protected $bdd;
   
    public function __construct()
    {
        try
        {  //conection to the data base
          $this-> bdd = new PDO('mysql:host=db.3wa.io;dbname=mohammedhas_project_3wa;charset=utf8','mohammedhas','46dfb784fbe065d8922b515a40a0dbe2');
            /* $this-> bdd = new PDO('mysql:host=localhost;dbname=project 3wa;charset=utf8','root',''); */
          $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        catch (Exception $e)
        {
           echo $e;
        }

    }
    
    public function queryFetchAll($req,$params = [])
    {
        //preparation 
        $query = $this -> bdd -> prepare($req);
        //excute
        $query -> execute($params);
        //collect data
        return $query -> fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function queryFetch($req,$params = [])
    {
        //preparation 
        $query = $this -> bdd -> prepare($req);
        //excute
        $query -> execute($params);
        //collect data
        return $query -> fetch(PDO::FETCH_ASSOC);
    }
         // insert 
    public function query($req,$params = [])
    {
        //preparation 
        $query = $this -> bdd -> prepare($req);
        //excute
        return $query -> execute($params);
    }

    //get the last auto-incremented id in order to find the booking  id to connect to adding   table booking details
    public function getLastId()
    {
        return $this->bdd->lastInsertId();//returns last inserted id
        
    }
}   