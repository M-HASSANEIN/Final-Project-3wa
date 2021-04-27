<?php
class PhotosRoom extends ModelManager
{
    public function GetPhotos()
    {
        $req =
              "SELECT * FROM `photosrooms`"  ;
               return $this -> queryFetchAll($req);
    }
    public function AddPhotoroom($photo,$name,$id_room)
    {
        $req=
        
              "INSERT INTO photosrooms(src,alt,id_room) VALUES (?,?,?)";
              $this -> query($req,[$photo,$name,$id_room]);
       
    }
   //UPdate room with  photo  
   public function UpDateRoomphotoDbase($photo,$name,$id_room)
   {
       $req =
               "UPDATE photosrooms SET src=?,alt=? WHERE id_room = ?";
               
        return  $this -> query($req,[$photo,$name,$id_room]);
   }

}