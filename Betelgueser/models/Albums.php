<?php

class Albums extends ModelManager
{    
    // get all data of the albums from data base 
    public function GetAlbums()
    {
       
        $req =
        
              "SELECT * FROM `albums`"  ;
               return $this -> queryFetchAll($req);
        
    }
    //add album to the data base
    public function AddAlbumDbase($name, $image,$date)
    {
        
         $req =
               
               " INSERT INTO albums(`name`,`image`,`date`) VALUES (?,?,?)";
                 $this -> query($req,[$name, $image,$date]);
        
    }
    //delete album from data base
    public function DeleteAlbumfromDbase($id)
    {
        
        $req =
               "DELETE FROM albums WHERE albums.id_album=?";
              /*  "DELETE FROM gallery WHERE gallery.id_album=?"; */
                $this -> query($req,[$id]);
        
    }
    //up date full album from to data base
    public function  UpDateAlbumDbase($name,$image,$date,$id)
    {
        $req =
                "UPDATE albums SET `name`=? ,`image`=?, `date`=? WHERE id_album=?";
                 return  $this -> query($req,[$name, $image,$date,$id]);
    }
    //up date NAME OF album from to data base
    public function  UpDateAlbumNameDbase($name,$date,$id)
    {
        $req =
                "UPDATE albums SET `name`=? , `date`=?  
                 WHERE id_album=?";
                 return  $this -> query($req,[$name,$date,$id]);
    }
     //CALL ALBUM FROM DATA BASE BY ID 
    public function CallAlbumbyId($id)
    {
        $req = 
                 " SELECT `name`,`image`,`date`,`id_album`
                   FROM albums
                   WHERE id_album=?";
                  
                  return  $this -> queryFetch($req,[$id]);

    }

}