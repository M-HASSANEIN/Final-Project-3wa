<?php

class About extends ModelManager
{   //get all info from table about
    public function GetALLAbout()
    {
        $req =
               "SELECT * FROM `about`" ;
                return $this -> queryFetchAll($req);
    }
    public function CallAboutById($id_about)
    {
        $req =
               "SELECT * FROM `about`
                WHERE id_about=?" ;
              
                return $this -> queryFetch($req,[$id_about]);
    }
    //update photo  of about in data base
    public function  UpDateAboutDbase($content,$src,$name,$id_about)
    {
        $req =
                "UPDATE about SET about_content=?, about_img=?,`about_img_alt`=? WHERE id_about=?";
                
                 return  $this -> query($req,[$content,$src,$name,$id_about]);
    }
    ////update about without photo  name 
    public function  UpDateAboutWithoutPhotoDbase($content,$name,$id_about)
    {
        $req = 
              "UPDATE about SET about_content=?,`about_img_alt`=? WHERE id_about=?";
                
              return  $this -> query($req,[$content,$name,$id_about]);
    }

   
}