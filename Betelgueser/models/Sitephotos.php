<?php

class SitePhotos extends ModelManager
{   //get all photos from table sitephotos
    public function GetALLSitePhotos()
    {
        $req =
               "SELECT * FROM `sitephotos`" ;
                return $this -> queryFetchAll($req);
    }
    //CALL PHOTO BY ID
    public function CallPhotoSiteById($id_PHOTO)
    {
        $req =
               "SELECT * FROM `sitephotos`
                WHERE id_sitephotos=?" ;
                return $this -> queryFetch($req,[$id_PHOTO]);
    }
    //update photo  of site in data base
    public function  UpDateSitePhotoDbase($src,$name,$date,$id_PHOTO)
    {
        $req =
                "UPDATE sitephotos SET src=?, alt=?,`date`=? WHERE id_sitephotos=?";
                
                 return  $this -> query($req,[$src,$name,$date,$id_PHOTO]);
    }
   
}