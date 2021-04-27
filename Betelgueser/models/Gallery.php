<?php
class Gallery extends ModelManager
{
    public function GetGallery()
    {
        $req =
              "SELECT * FROM `gallery`"  ;
               return $this -> queryFetchAll($req);
        
    }

    public function AddGalleryDbase($id_album,$src,$alt,$date)
    {
        
         $req =
               " INSERT INTO gallery(`id_album`,`src`,`alt`,`date`) VALUES (?,?,?,?)";
                 $this -> query($req,[$id_album,$src,$alt,$date]);
    }

    public function DeletePhotoDbase($id)
    {
        $req =
                "DELETE FROM gallery WHERE id_gallery = ?";
                $this -> query($req,[$id]);
    }
     //call photo by id album
    public function CallPhotobyId($id)
    {
        $req = 
                 " SELECT *
                   FROM gallery
                   WHERE id_album=?";
                   return $this -> queryFetchAll($req,[$id]);

    }
    //call photo by id photo
    public function CallPhotobyIdPhoto($id)
    {
        $req = 
                 " SELECT *
                   FROM gallery
                   WHERE id_gallery=?";
                   return $this -> queryFetch($req,[$id]);

    }
    //update photo in data base
    public function  UpDatePhotoDbase($src,$name,$date,$id_gallery)
    {
        $req =
                "UPDATE gallery SET src=?, alt=?,`date`=? WHERE id_gallery=?";
                 return  $this -> query($req,[$src,$name,$date,$id_gallery]);
    }
    ////update photo name 
    public function  UpDateNamePhotoDbase($name,$date,$id_gallery)
    {
        $req =
                "UPDATE gallery SET alt=?,`date`=? WHERE id_gallery=?";
                 return  $this -> query($req,[$name,$date,$id_gallery]);
    }
    ////update album  name 
    public function  UpDateAbumNameGalleryDbase($oldname,$newname,$date,$id)
    {
        $req =
                "UPDATE gallery SET `src` = replace(src,?,?),`date`=? WHERE id_album=?";
                 return  $this -> query($req,[$oldname,$newname,$date,$id]);
    }



}