<?php 

class GalleryBackController extends SiteBaseController
{
 
  //gallery photo front
  public function ShowGallery_Back()

  {
     //get album id from url 
     $id_album=$_GET["id"];
     
     //get album ti  galary page by theier id 
     $model=new Albums();
     /*  */
     $album=$model->CallAlbumbyId($id_album);
     $_SESSION["name"]=$album["name"];
     $_SESSION["id_album"]=$album["id_album"];
  
     //show all photo galary 
     $model=new Gallery ();
     $photos=$model->CallPhotobyId($id_album);
     
     $title="GALLERY-BACK";
     $template = 'Gallery_Back.phtml';
     include 'views/LayoutBackend.phtml';

  }
  
  public function UpLoadPhotoBackend()
  {
       
     //if we click over upload when we select a photo
      if(isset($_POST["submit-photo"]))
      {
        
        $errors="";
          //determine  the type of the file 
        $expensions= array("jpeg","jpg","png");
        $countfiles = count($_FILES['images']['name']);
         for($i=0;$i<$countfiles;$i++)
         {
            $file_name = $_FILES['images']['name'][$i];
            $file_size = $_FILES['images']['size'][$i];
            $file_tmp = $_FILES['images']['tmp_name'][$i];
            $file_type = $_FILES['images']['type'][$i];
            $value_ext=explode('.', $file_name);
            $file_ext=strtolower(end($value_ext));
            
            //if the name doex not exist
            $alt=$_POST["alt"];
            if ($_POST["alt"]=="")
            {
             $alt="photo";
            }
            //get id album to add the photo to data base 
            $id_album=$_POST["id"];
            $date = date('Y-m-d H:i:s');
            //verfiy type of the photo
            //if the upload photo  is empty 
            if(isset($_POST["submit-photo"]) && empty( $file_name))
            {
              $errors='You must select photo';
              $model=new Gallery ();
              $photos=$model->GetGallery();
              $model=new Albums();
              $albums=$model->GetAlbums();
              $title="GALLERY-BACK";
              $template = 'Gallery_Back.phtml';
              include 'views/LayoutBackend.phtml';
            }  
            if(in_array($file_ext,$expensions,$file_type)=== false){
              $errors="extension not allowed, please choose a JPEG or PNG file.";
              $model=new Gallery ();
              $photos=$model->GetGallery();
              $model=new Albums();
              $albums=$model->GetAlbums();
              $title="GALLERY-BACK";
              $template = 'Gallery_Back.phtml';
              include 'views/LayoutBackend.phtml';   
            }
            //max size 10MB
            if($file_size > 10097152)
            {
              $errors='File size must be excately 10 MB';
              $model=new Gallery ();
              $photos=$model->GetGallery();
              $model=new Albums();
              $albums=$model->GetAlbums();
              $title="GALLERY-BACK";
              $template = 'Gallery_Back.phtml';
              include 'views/LayoutBackend.phtml';
            }
              //get album name
             $folder=$_POST["name"];
             $src ="assets/Albums/$folder/"; //you must be care of the space bet the slash and the $folder //import!!!!!!!
            //if all is ok it will upload the photo in the album
            if (file_exists($src.$file_name))
            {
              $errors="Photo name is already existe";
              $model=new Gallery ();
              $photos=$model->GetGallery();
              $model=new Albums();
              $albums=$model->GetAlbums();
              $title="GALLERY-BACK";
              $template = 'Gallery_Back.phtml';
              include 'views/LayoutBackend.phtml';
            }
            if(empty($errors)==true)
            { 
              //add photo to data base
             $model = new Gallery();
             $model ->AddGalleryDbase($id_album,$src.$file_name ,$alt,$date);
              ///add photo to folder 
             move_uploaded_file($file_tmp,$src.$file_name);
             $success="The Photo has been uploaded";
            }
         } 
         
          //call all photo from database after we add new photo 
          $model=new Gallery ();
          $photos=$model->GetGallery();
          $model=new Albums();
          $albums=$model->GetAlbums();
          $title="GALLERY-BACK";
          $template = 'Gallery_Back.phtml';
          include 'views/LayoutBackend.phtml';
       } 
  } //delet photo from data basee
  public function deletePhoto()
  {
    $id=$_GET["PHOTO"];
    $file=$_GET["IMAGE"];
    $model=new Gallery();
    $model->DeletePhotoDbase($id);
    unlink($file);
    $success="The Photo has been deleted";
    $model=new Gallery ();
    $photos=$model->GetGallery();
    $model=new Albums();
    $albums=$model->GetAlbums();
    $title="GALLERY-BACK";
    $template = 'Gallery_Back.phtml';
    include 'views/LayoutBackend.phtml';
  }
  //get photo from data base by id 
  public function GetPhotoInfoById()
  {
       $id=$_GET["PHOTO"];
       $model=new Gallery();
       $photo=$model->CallPhotobyIdPhoto($id);
       $title="EditPhoto";
       $template = 'AddNewPhoto_Back.phtml';
       include 'views/LayoutBackend.phtml';
  }
  public function UpDatePhotoInDBase()
  {
     
      $name=$_POST["alt"];
      if ($name==="") {
        $name="photo";
      }
      $id_gallery=$_GET['PHOTO'];
      $srcOld=$_GET["SRC"];
      $date = date('Y-m-d H:i:s');
      if(isset($_POST["submit-photo"]) && !empty($_FILES["image"]["name"]))
    {
      $errors= "";
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $value_ext=explode('.', $file_name);
      $file_ext=strtolower(end($value_ext));
      //determine  the type of the file 
      $expensions= array("jpeg","jpg","png");
      //
      if(in_array($file_ext,$expensions,$file_type)=== false)
      {
        $errors="extension not allowed, please choose a JPEG or PNG file.";
        $model=new Gallery();
        $photo=$model->CallPhotobyIdPhoto($id_gallery);
        $title="EditPhoto";
        $template = 'AddNewPhoto_Back.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
      //max size 10MB
      if($file_size > 10097152) ///must be modify
      {
        $errors='File size must be excately 10 MB';
        $model=new Gallery();
        $photo=$model->CallPhotobyIdPhoto($id_gallery);
        $title="EditPhoto";
        $template = 'AddNewPhoto_Back.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
       //get album name
       $model=new Gallery();
       $photo=$model->CallPhotobyIdPhoto($id_gallery);
       $id_album=$photo["id_album"];
       $model=new Albums;
       $album=$model->CallAlbumbyId($id_album);
       $folder=$album["name"];
       $NewSrc ="assets/Albums/$folder/";
      //if all is ok it will upload the photo 
      if (file_exists($NewSrc.$file_name))
      { 
        $errors="Photo name is already existe"; 
        $model=new Gallery();
        $photo=$model->CallPhotobyIdPhoto($id_gallery);
        $title="EditPhoto";
        $template = 'AddNewPhoto_Back.phtml';
        include 'views/LayoutBackend.phtml';
        exit();
      }
      if(empty($errors)==true)
      { 
        $model=new Gallery();
        $model->UpDatePhotoDbase($NewSrc.$file_name,$name,$date,$id_gallery);
        move_uploaded_file($file_tmp,$NewSrc.$file_name);
        unlink($srcOld);
        $this->ShowGallerBack();
      }
    }else {
      
      $model=new Gallery();
      $model->UpDateNamePhotoDbase($name,$date,$id_gallery);
      $success="Photo name has been changed";
      $model=new Gallery ();
      $photos=$model->GetGallery();
      $model=new Albums();
      $albums=$model->GetAlbums();
      $title="GALLERY-BACK";
      $template = 'Gallery_Back.phtml';
      include 'views/LayoutBackend.phtml'; 
      }
  }

  //call gallery photo of the album when we click back
  public function ShowGallerBack()
  {
    $model=new Gallery ();
    $photos=$model->GetGallery();
    $model=new Albums();
    $albums=$model->GetAlbums();
    $title="GALLERY-BACK";
    $template = 'Gallery_Back.phtml';
    include 'views/LayoutBackend.phtml'; 
  }
}
/*  echo '<pre>';
  var_dump( $error);
   echo '</pre>';

 */

/* echo '<pre>';
var_dump( $id_gallery);
 echo '</pre>';


echo '<pre>';
var_dump( $NewSrc.$file_name);
 echo '</pre>';


echo '<pre>';
var_dump( $name);
 echo '</pre>';


echo '<pre>';
var_dump( $date);
 echo '</pre>';
 echo '<pre>';
 var_dump( $srcOld);
  echo '</pre>';
 */